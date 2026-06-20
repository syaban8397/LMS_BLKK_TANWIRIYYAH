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
        $updated = 0;

        foreach ($statuses as $participantId => $status) {
            if (!in_array($status, ['pass', 'fail'], true)) {
                continue;
            }

            ClassParticipant::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->firstOrFail();

            $this->updateStatus($class, (int) $participantId, $status);

            $updated++;
        }

        return $updated;
    }

    public function bulkIssue(ClassModel $class, array $participantIds): array
    {
        $issued = [];
        $errors = [];

        foreach ($participantIds as $participantId) {
            try {
                $this->issue($class, (int) $participantId);
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

    public function issue(ClassModel $class, int $participantId): Certificate
    {
        return DB::transaction(function () use ($class, $participantId) {
            $class->load('program');

            $finalGrade = FinalGrade::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->first();

            if (!$finalGrade || $finalGrade->status !== 'pass') {
                throw new \RuntimeException(__('lms.flash.participant_not_passed'));
            }

            $stats = collect($this->getClassStats($class))
                ->first(fn ($row) => $row['participant']->id === $participantId);

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
        $fonts = $this->certificateFonts();

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
            'fonts' => $fonts,
            'organization' => config('certificate.organization', 'YMT Creator Base BLKK Tanwiriyyah - Kementerian Ketenagakerjaan RI'),
            'organizationEn' => config('certificate.organization_en', 'BLKK Tanwiriyyah - Ministry of Manpower'),
            'directorName' => config('certificate.director_name', 'Zaid Ahmad, S.Kom.'),
            'directorTitleLine1' => config('certificate.director_title_line1', 'Direktur YMT Creator Base'),
            'directorTitleLine2' => config('certificate.director_title_line2', 'BLKK Tanwiriyyah'),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('dpi', 200)
            ->setOption('defaultFont', 'Montserrat')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isFontSubsettingEnabled', true);

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
}
