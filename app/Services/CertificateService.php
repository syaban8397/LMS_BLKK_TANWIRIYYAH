<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\FinalGrade;
use App\Models\Material;
use App\Models\Submission;
use App\Models\User;
use App\Support\CertificateTextRenderer;
use App\Support\SecureStorage;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function getClassStats(ClassModel $class): array
    {
        $class->load(['program', 'instructor']);

        $totalMeetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number')
            ->distinct()
            ->count();

        $totalAssignments = Assignment::where('class_id', $class->id)->count();

        $students = ClassParticipant::where('class_id', $class->id)
            ->with(['participant', 'participant.certificates' => fn ($q) => $q->where('class_id', $class->id)])
            ->get();

        $finalGrades = FinalGrade::where('class_id', $class->id)
            ->get()
            ->keyBy('participant_id');

        $certificates = Certificate::where('class_id', $class->id)
            ->get()
            ->keyBy('participant_id');

        $attendanceCounts = Attendance::where('class_id', $class->id)
            ->whereIn('status', ['present', 'permission', 'sick'])
            ->selectRaw('participant_id, COUNT(*) as aggregate')
            ->groupBy('participant_id')
            ->pluck('aggregate', 'participant_id');

        $assignmentIds = Assignment::where('class_id', $class->id)->pluck('id');

        $submissionCounts = $assignmentIds->isEmpty()
            ? collect()
            : Submission::whereIn('assignment_id', $assignmentIds)
                ->whereIn('status', ['submitted', 'late', 'graded'])
                ->selectRaw('participant_id, COUNT(*) as aggregate')
                ->groupBy('participant_id')
                ->pluck('aggregate', 'participant_id');

        return $students->map(function ($enrollment) use (
            $totalMeetings,
            $totalAssignments,
            $finalGrades,
            $certificates,
            $attendanceCounts,
            $submissionCounts
        ) {
            $participantId = $enrollment->participant_id;

            $attendanceCount = (int) ($attendanceCounts[$participantId] ?? 0);
            $submissionCount = (int) ($submissionCounts[$participantId] ?? 0);

            $attendancePercentage = $totalMeetings > 0
                ? round(($attendanceCount / $totalMeetings) * 100, 2)
                : 0;

            return [
                'enrollment' => $enrollment,
                'participant' => $enrollment->participant,
                'attendance_count' => $attendanceCount,
                'total_meetings' => $totalMeetings,
                'submission_count' => $submissionCount,
                'total_assignments' => $totalAssignments,
                'attendance_percentage' => $attendancePercentage,
                'final_grade' => $finalGrades->get($participantId),
                'certificate' => $certificates->get($participantId),
            ];
        })->all();
    }

    public function updateStatus(ClassModel $class, int $participantId, string $status): FinalGrade
    {
        $attendancePercentage = $this->attendancePercentageForParticipant($class, $participantId);

        $finalGrade = FinalGrade::firstOrNew([
            'class_id' => $class->id,
            'participant_id' => $participantId,
        ]);

        $finalGrade->attendance_score = $attendancePercentage;
        $finalGrade->assignment_score = $finalGrade->assignment_score ?? 0;
        $finalGrade->final_score = $finalGrade->final_score ?? $finalGrade->attendance_score;
        $finalGrade->status = $status;
        $finalGrade->save();

        return $finalGrade;
    }

    protected function attendancePercentageForParticipant(ClassModel $class, int $participantId): float
    {
        $totalMeetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number')
            ->distinct()
            ->count();

        if ($totalMeetings === 0) {
            return 0;
        }

        $attendanceCount = Attendance::where('class_id', $class->id)
            ->where('participant_id', $participantId)
            ->whereIn('status', ['present', 'permission', 'sick'])
            ->count();

        return round(($attendanceCount / $totalMeetings) * 100, 2);
    }

    public function bulkUpdateStatus(ClassModel $class, array $statuses): int
    {
        $totalMeetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number')
            ->distinct()
            ->count();

        $attendanceCounts = Attendance::where('class_id', $class->id)
            ->whereIn('status', ['present', 'permission', 'sick'])
            ->selectRaw('participant_id, COUNT(*) as aggregate')
            ->groupBy('participant_id')
            ->pluck('aggregate', 'participant_id');

        $updated = 0;

        foreach ($statuses as $participantId => $status) {
            if (!in_array($status, ['pass', 'fail'], true)) {
                continue;
            }

            ClassParticipant::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->firstOrFail();

            $attendanceCount = (int) ($attendanceCounts[$participantId] ?? 0);
            $attendancePercentage = $totalMeetings > 0
                ? round(($attendanceCount / $totalMeetings) * 100, 2)
                : 0;

            $finalGrade = FinalGrade::firstOrNew([
                'class_id' => $class->id,
                'participant_id' => (int) $participantId,
            ]);

            $finalGrade->attendance_score = $attendancePercentage;
            $finalGrade->assignment_score = $finalGrade->assignment_score ?? 0;
            $finalGrade->final_score = $finalGrade->final_score ?? $finalGrade->attendance_score;
            $finalGrade->status = $status;
            $finalGrade->save();

            $updated++;
        }

        return $updated;
    }

    public function bulkIssue(ClassModel $class, array $participantIds): array
    {
        $statsByParticipant = collect($this->getClassStats($class))
            ->keyBy(fn (array $row) => $row['participant']->id);

        $issued = [];
        $errors = [];

        foreach ($participantIds as $participantId) {
            try {
                $this->issue(
                    $class,
                    (int) $participantId,
                    $statsByParticipant->get((int) $participantId)
                );
                $issued[] = $participantId;
            } catch (\RuntimeException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return compact('issued', 'errors');
    }

    public function delete(Certificate $certificate): void
    {
        DB::transaction(function () use ($certificate) {
            SecureStorage::delete($certificate->pdf_file);
            SecureStorage::delete($certificate->qr_code);
            $certificate->delete();
        });
    }

    public function issue(ClassModel $class, int $participantId, ?array $precomputedStats = null): Certificate
    {
        return DB::transaction(function () use ($class, $participantId, $precomputedStats) {
            $class->load('program');

            $finalGrade = FinalGrade::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->first();

            if (!$finalGrade || $finalGrade->status !== 'pass') {
                throw new \RuntimeException(__('lms.flash.participant_not_passed'));
            }

            if ($precomputedStats !== null) {
                $stats = $precomputedStats;
            } else {
                $stats = collect($this->getClassStats($class))
                    ->first(fn ($row) => $row['participant']->id === $participantId);
            }

            $certificate = Certificate::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->lockForUpdate()
                ->first();

            if (!$certificate) {
                $certificate = new Certificate([
                    'class_id' => $class->id,
                    'participant_id' => $participantId,
                ]);
            }

            if (!$certificate->certificate_number) {
                $certificate->certificate_number = $this->generateNumber($class, $participantId);
            }

            $certificate->final_score = $finalGrade->final_score ?? 0;
            $certificate->attendance_percentage = $stats['attendance_percentage'] ?? 0;
            $certificate->issued_at = now();

            $verifyUrl = route('certificates.verify', $certificate->certificate_number);
            $certificate->qr_code = $this->storeQrCode($certificate->certificate_number, $verifyUrl);

            $pdfPath = $this->generatePdf($class, $certificate);
            $certificate->pdf_file = $pdfPath;
            $certificate->save();

            return $certificate;
        });
    }

    protected function generateNumber(ClassModel $class, int $participantId): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $class->code), 0, 2)) ?: 'DM';

        return sprintf(
            '%s%02d%04d%04d-%s',
            $prefix,
            $class->id,
            $participantId,
            random_int(1000, 9999),
            config('certificate.number_suffix')
        );
    }

    protected function storeQrCode(string $number, string $url): string
    {
        $path = 'certificates/qr/' . $number . '.png';
        $this->putRequired($path, $this->renderQrPng($url));

        return $path;
    }

    protected function renderQrPng(string $content, int $targetSize = 320, int $marginModules = 1): string
    {
        if (! extension_loaded('gd')) {
            throw new \RuntimeException('GD extension required to render certificate QR codes.');
        }

        $qr = Encoder::encode($content, ErrorCorrectionLevel::L());
        $matrix = $qr->getMatrix();
        $moduleCount = $matrix->getWidth();
        $totalModules = $moduleCount + ($marginModules * 2);
        $moduleSize = max(1, (int) floor($targetSize / $totalModules));
        $imageSize = $totalModules * $moduleSize;

        $img = imagecreatetruecolor($imageSize, $imageSize);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefill($img, 0, 0, $white);

        for ($y = 0; $y < $moduleCount; $y++) {
            for ($x = 0; $x < $moduleCount; $x++) {
                if ($matrix->get($x, $y) === 1) {
                    $px = ($x + $marginModules) * $moduleSize;
                    $py = ($y + $marginModules) * $moduleSize;
                    imagefilledrectangle(
                        $img,
                        $px,
                        $py,
                        $px + $moduleSize - 1,
                        $py + $moduleSize - 1,
                        $black
                    );
                }
            }
        }

        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);

        return $png;
    }

    protected function qrDataUri(string $path): string
    {
        $content = SecureStorage::get($path);
        $lower = strtolower($path);
        $mime = str_ends_with($lower, '.svg')
            ? 'image/svg+xml'
            : (str_ends_with($lower, '.png') ? 'image/png' : 'image/png');

        return 'data:' . $mime . ';base64,' . base64_encode($content);
    }

    protected function imageBase64(string $filename): ?string
    {
        foreach ($this->certificateImagePaths($filename) as $path) {
            if (file_exists($path)) {
                return base64_encode(file_get_contents($path));
            }
        }

        return null;
    }

    protected function page2WatermarkBase64(): ?string
    {
        $path = null;
        foreach ($this->certificateImagePaths('logo-blkk.png') as $candidate) {
            if (file_exists($candidate)) {
                $path = $candidate;
                break;
            }
        }

        if ($path === null) {
            return null;
        }

        if (!function_exists('imagecreatefrompng')) {
            return base64_encode(file_get_contents($path));
        }

        $source = @imagecreatefrompng($path);
        if ($source === false) {
            return base64_encode(file_get_contents($path));
        }

        $targetSize = 480;
        $target = imagecreatetruecolor($targetSize, $targetSize);
        imagealphablending($target, false);
        imagesavealpha($target, true);
        $transparent = imagecolorallocatealpha($target, 255, 255, 255, 127);
        imagefill($target, 0, 0, $transparent);
        imagealphablending($target, true);

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            0,
            0,
            $targetSize,
            $targetSize,
            $sourceWidth,
            $sourceHeight
        );
        imagedestroy($source);

        imagealphablending($target, false);
        imagesavealpha($target, true);
        for ($x = 0; $x < $targetSize; $x++) {
            for ($y = 0; $y < $targetSize; $y++) {
                $rgba = imagecolorat($target, $x, $y);
                $alpha = ($rgba >> 24) & 0x7F;
                if ($alpha === 127) {
                    continue;
                }
                $red = ($rgba >> 16) & 0xFF;
                $green = ($rgba >> 8) & 0xFF;
                $blue = $rgba & 0xFF;
                $fadedAlpha = 127 - (int) round((127 - $alpha) * 0.10);
                $color = imagecolorallocatealpha($target, $red, $green, $blue, $fadedAlpha);
                imagesetpixel($target, $x, $y, $color);
            }
        }

        ob_start();
        imagepng($target);
        $png = ob_get_clean();
        imagedestroy($target);

        return base64_encode($png);
    }

    /**
     * @return list<string>
     */
    protected function certificateImagePaths(string $filename): array
    {
        $paths = [];

        if (in_array(strtolower($filename), ['logo.png', 'logo'], true)) {
            foreach (['logo.png', 'Logo.png'] as $logoFile) {
                $paths[] = public_path('storage/images/' . $logoFile);
                $paths[] = Storage::disk('public')->path('images/' . $logoFile);
            }
        }

        $paths[] = public_path('images/certificates/' . $filename);

        return $paths;
    }

    protected function certificateFonts(): array
    {
        $dir = storage_path('fonts/certificates');
        $files = [
            'bold' => 'Montserrat-Bold.ttf',
            'bold_italic' => 'Montserrat-BoldItalic.ttf',
            'black' => 'Montserrat-Black.ttf',
            'italic' => 'Montserrat-Italic.ttf',
            'regular' => 'Montserrat-Regular.ttf',
        ];
        $fonts = [];

        foreach ($files as $key => $filename) {
            $path = $dir . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($path)) {
                $fonts[$key] = base64_encode(file_get_contents($path));
            }
        }

        return $fonts;
    }

    protected function certificateLogos(): array
    {
        $logo = $this->imageBase64('logo.png');

        return [
            'page1_reference_bg' => $this->imageBase64('page1-reference-bg.png'),
            'sidebar_bg' => $this->imageBase64('sidebar-bg.png'),
            'kemnaker' => $this->imageBase64('logo-kemnaker.png'),
            'kemnaker_mark' => $this->imageBase64('logo-kemnaker-mark.png'),
            'logo' => $logo,
            'ymt' => $this->imageBase64('logo-ymt-creatorbase.png') ?: $logo,
            'vokasi' => $this->imageBase64('logo-pelatihan-vokasi.png'),
            'indonesia_skills' => $this->imageBase64('logo-indonesia-skills.png'),
            'skills_swoosh' => $this->imageBase64('logo-skills-swoosh.png'),
            'blkk_mark' => $this->imageBase64('logo-blkk.png'),
            'siapkerja' => $this->imageBase64('logo-siapkerja.png'),
            'page2_watermark' => $this->page2WatermarkBase64(),
            'materials_watermark' => $this->imageBase64('modules-watermark.png'),
        ];
    }

    public function generatePdf(ClassModel $class, Certificate $certificate): string
    {
        $class->load(['program']);
        $certificate->load('participant');

        $materials = Material::where('class_id', $class->id)
            ->orderBy('meeting_number')
            ->orderBy('title')
            ->get();

        $program = $class->program;
        $validityYears = $program->validity_years ?? config('certificate.default_validity_years', 3);
        $degree = $program->certificate_degree_label;

        $qrPath = $certificate->qr_code;
        $logos = $this->certificateLogos();
        $programLines = $this->page1ProgramLines($program, $class);
        $page1Dynamic = $this->buildPage1DynamicLayers(
            $certificate,
            $degree,
            $validityYears,
            $programLines
        );
        $page2Dynamic = $this->buildPage2DynamicLayers($materials);

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'class' => $class,
            'program' => $program,
            'participant' => $certificate->participant,
            'materials' => $materials,
            'degree' => $degree,
            'validityYears' => $validityYears,
            'trainingYear' => $class->end_date->format('Y'),
            'qrDataUri' => $this->qrDataUri($qrPath),
            'logos' => $logos,
            'page1Masks' => $page1Dynamic['masks'],
            'page1Layers' => $page1Dynamic['layers'],
            'page2Layers' => $page2Dynamic['layers'],
            'programLines' => $programLines,
            'hasProgramLine2' => isset($programLines[1]),
            'organization' => config('certificate.organization', 'YMT Creator Base BLKK Tanwiriyyah - Kementerian Ketenagakerjaan RI'),
            'organizationEn' => config('certificate.organization_en', 'BLKK Tanwiriyyah - Ministry of Manpower'),
            'directorName' => config('certificate.director_name', 'Zaid Ahmad, S.Kom.'),
            'directorTitleLine1' => config('certificate.director_title_line1', 'Direktur YMT Creator Base'),
            'directorTitleLine2' => config('certificate.director_title_line2', 'BLKK Tanwiriyyah'),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('dpi', 200)
            ->setOption('defaultFont', 'montserrat')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isFontSubsettingEnabled', false);

        $path = 'certificates/pdf/' . $certificate->certificate_number . '.pdf';
        $this->putRequired($path, $pdf->output());

        return $path;
    }

    protected function putRequired(string $path, $contents): void
    {
        SecureStorage::put($path, $contents);

        if (!SecureStorage::exists($path)) {
            throw new \RuntimeException(__('lms.flash.certificate_storage_failed'));
        }
    }

    public function downloadPath(Certificate $certificate): ?string
    {
        if (!$certificate->pdf_file || !SecureStorage::exists($certificate->pdf_file)) {
            return null;
        }

        return SecureStorage::path($certificate->pdf_file);
    }

    public function downloadFilename(Certificate $certificate): string
    {
        $certificate->loadMissing('participant');

        $name = strtoupper(trim($certificate->participant->name ?? 'SERTIFIKAT'));
        $name = preg_replace('/[\\\\\/:*?"<>|]/', '', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return ($name !== '' ? $name : 'SERTIFIKAT') . '.pdf';
    }

    /**
     * @return list<string>
     */
    protected function page1ProgramLines(\App\Models\Program $program, ClassModel $class): array
    {
        $programName = $program->name;
        $trainingYear = $class->end_date->format('Y');

        if (preg_match('/^(.+?)\s+(Skema\s+.+)$/iu', $programName, $skemaMatch)) {
            return [
                'Telah Berpartisipasi Pada Pelatihan ' . trim($skemaMatch[1]),
                trim($skemaMatch[2]) . ' Tahun ' . $trainingYear,
            ];
        }

        return [
            'Telah Berpartisipasi Pada Pelatihan ' . $programName . ' Tahun ' . $trainingYear,
        ];
    }

    /**
     * @param  list<string>  $programLines
     * @return array{masks: list<array{l: float, t: float, w: float, h: float}>, layers: list<array{top: float, left: float, width: float, base64: string}>}
     */
    protected function buildPage1DynamicLayers(
        Certificate $certificate,
        string $degree,
        int $validityYears,
        array $programLines
    ): array {
        $validityWordId = match ((int) $validityYears) {
            1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima',
            default => (string) $validityYears,
        };
        $validityWordEn = match ((int) $validityYears) {
            1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
            default => (string) $validityYears,
        };

        $masks = [
            ['l' => 103.0, 't' => 45.0, 'w' => 162.0, 'h' => 16.5],
            ['l' => 78.0, 't' => 77.0, 'w' => 200.0, 'h' => 22.0],
            ['l' => 118.0, 't' => 119.0, 'w' => 136.0, 'h' => 14.0],
            ['l' => 122.0, 't' => 132.0, 'w' => 126.0, 'h' => 20.0],
            ['l' => 235.0, 't' => 185.0, 'w' => 58.0, 'h' => 18.0],
            ['l' => 169.0, 't' => 162.0, 'w' => 24.5, 'h' => 24.5],
        ];

        $render = static fn (array $options): string => CertificateTextRenderer::render($options);

        $layers = [
            [
                'top' => 47.9,
                'left' => 106.2,
                'width' => 152.0,
                'base64' => $render([
                    'text' => strtoupper($certificate->participant->name),
                    'fontFile' => CertificateTextRenderer::fontPath('black'),
                    'fontSizePt' => 25,
                    'color' => '#000000',
                    'widthMm' => 152.0,
                    'align' => 'center',
                ]),
            ],
            [
                'top' => 79.6,
                'left' => 83.5,
                'width' => 196.0,
                'base64' => $render([
                    'text' => $programLines[0],
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 15,
                    'color' => '#002d5b',
                    'widthMm' => 196.0,
                    'align' => 'left',
                ]),
            ],
            [
                'top' => 122.3,
                'left' => 121.6,
                'width' => 130.0,
                'base64' => $render([
                    'text' => $degree,
                    'fontFile' => CertificateTextRenderer::fontPath('black'),
                    'fontSizePt' => 17,
                    'color' => '#b91c1c',
                    'widthMm' => 130.0,
                    'align' => 'left',
                ]),
            ],
            [
                'top' => 134.5,
                'left' => 125.4,
                'width' => 122.0,
                'base64' => $render([
                    'text' => "Sertifikat ini berlaku untuk : {$validityYears} ({$validityWordId}) Tahun",
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 15,
                    'color' => '#002d5b',
                    'widthMm' => 122.0,
                    'align' => 'left',
                ]),
            ],
            [
                'top' => 142.3,
                'left' => 135.3,
                'width' => 102.0,
                'base64' => $render([
                    'text' => "This Certificate is valid for {$validityYears} ({$validityWordEn}) years",
                    'fontFile' => CertificateTextRenderer::fontPath('italic'),
                    'fontSizePt' => 13,
                    'color' => '#757575',
                    'widthMm' => 102.0,
                    'align' => 'left',
                ]),
            ],
            [
                'top' => 191.8,
                'left' => 238.0,
                'width' => 49.0,
                'base64' => $render([
                    'text' => $certificate->certificate_number,
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 10,
                    'color' => '#002d5b',
                    'widthMm' => 49.0,
                    'align' => 'left',
                ]),
            ],
            [
                'top' => 196.5,
                'left' => 241.9,
                'width' => 44.5,
                'base64' => $render([
                    'text' => 'Issued Date: ' . $certificate->issued_at->format('Y-m-d'),
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 10,
                    'color' => '#002d5b',
                    'widthMm' => 44.5,
                    'align' => 'left',
                ]),
            ],
        ];

        if (isset($programLines[1])) {
            $layers[] = [
                'top' => 87.0,
                'left' => 125.5,
                'width' => 106.5,
                'base64' => $render([
                    'text' => $programLines[1],
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 15,
                    'color' => '#002d5b',
                    'widthMm' => 106.5,
                    'align' => 'left',
                ]),
            ];
        }

        return [
            'masks' => $masks,
            'layers' => $layers,
        ];
    }

    /**
     * @return array{layers: list<array{top: float, left: float, width: float, base64: string}>}
     */
    protected function buildPage2DynamicLayers($materials): array
    {
        $maxRows = 11;
        $rowTextY = [41.56, 55.74, 70.19, 84.34, 97.84, 111.34, 125.08, 138.58, 152.31, 165.81, 179.31];
        $render = static fn (array $options): string => CertificateTextRenderer::render($options);

        $layers = [
            [
                'top' => 27.80,
                'left' => 10.60,
                'width' => 15.80,
                'base64' => $render([
                    'text' => 'NO',
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 13,
                    'color' => '#000000',
                    'widthMm' => 15.80,
                    'align' => 'center',
                ]),
            ],
            [
                'top' => 27.80,
                'left' => 26.40,
                'width' => 205.75,
                'base64' => $render([
                    'text' => 'MATERI PELATIHAN',
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 13,
                    'color' => '#000000',
                    'widthMm' => 205.75,
                    'align' => 'center',
                ]),
            ],
            [
                'top' => 28.48,
                'left' => 232.15,
                'width' => 54.36,
                'base64' => $render([
                    'text' => 'KODE UNIT',
                    'fontFile' => CertificateTextRenderer::fontPath('bold'),
                    'fontSizePt' => 11,
                    'color' => '#000000',
                    'widthMm' => 54.36,
                    'align' => 'center',
                ]),
            ],
        ];

        $indexed = $materials->values();

        for ($i = 0; $i < $maxRows; $i++) {
            $rowNum = $i + 1;
            $y = $rowTextY[$i];

            $layers[] = [
                'top' => $y,
                'left' => 10.60,
                'width' => 15.80,
                'base64' => $render([
                    'text' => (string) $rowNum,
                    'fontFile' => CertificateTextRenderer::fontPath('regular'),
                    'fontSizePt' => 13,
                    'color' => '#000000',
                    'widthMm' => 15.80,
                    'align' => 'center',
                ]),
            ];

            if ($indexed->has($i)) {
                $material = $indexed[$i];
                $layers[] = [
                    'top' => $y + 0.08,
                    'left' => 29.45,
                    'width' => 200.0,
                    'base64' => $render([
                        'text' => $material->title,
                        'fontFile' => CertificateTextRenderer::fontPath('regular'),
                        'fontSizePt' => 12,
                        'color' => '#000000',
                        'widthMm' => 200.0,
                        'align' => 'left',
                    ]),
                ];
                $layers[] = [
                    'top' => $y,
                    'left' => 232.15,
                    'width' => 54.36,
                    'base64' => $render([
                        'text' => $material->material_code ?: '-',
                        'fontFile' => CertificateTextRenderer::fontPath('regular'),
                        'fontSizePt' => 13,
                        'color' => '#000000',
                        'widthMm' => 54.36,
                        'align' => 'center',
                    ]),
                ];
            }
        }

        return ['layers' => $layers];
    }
}
