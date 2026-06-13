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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        return $students->map(function ($enrollment) use ($class, $totalMeetings, $totalAssignments, $finalGrades, $certificates) {
            $participantId = $enrollment->participant_id;

            $attendanceCount = Attendance::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->whereIn('status', ['present', 'permission', 'sick'])
                ->count();

            $submissionCount = Submission::where('participant_id', $participantId)
                ->whereHas('assignment', fn ($q) => $q->where('class_id', $class->id))
                ->whereIn('status', ['submitted', 'late', 'graded'])
                ->count();

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
        $stats = collect($this->getClassStats($class))
            ->first(fn ($row) => $row['participant']->id === $participantId);

        $finalGrade = FinalGrade::firstOrNew([
            'class_id' => $class->id,
            'participant_id' => $participantId,
        ]);

        $finalGrade->attendance_score = $stats['attendance_percentage'] ?? 0;
        $finalGrade->assignment_score = $finalGrade->assignment_score ?? 0;
        $finalGrade->final_score = $finalGrade->final_score ?? $finalGrade->attendance_score;
        $finalGrade->status = $status;
        $finalGrade->save();

        return $finalGrade;
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

    public function issue(ClassModel $class, int $participantId): Certificate
    {
        $class->load('program');

        $finalGrade = FinalGrade::where('class_id', $class->id)
            ->where('participant_id', $participantId)
            ->first();

        if (!$finalGrade || $finalGrade->status !== 'pass') {
            throw new \RuntimeException('Peserta belum ditandai lulus.');
        }

        $stats = collect($this->getClassStats($class))
            ->first(fn ($row) => $row['participant']->id === $participantId);

        $certificate = Certificate::firstOrNew([
            'class_id' => $class->id,
            'participant_id' => $participantId,
        ]);

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
        $path = 'certificates/qr/' . $number . '.svg';
        $svg = QrCode::format('svg')->size(200)->margin(1)->generate($url);
        Storage::disk('public')->put($path, $svg);

        return $path;
    }

    protected function qrDataUri(string $path): string
    {
        $content = Storage::disk('public')->get($path);
        $mime = str_ends_with(strtolower($path), '.svg') ? 'image/svg+xml' : 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode($content);
    }

    protected function imageBase64(string $filename): ?string
    {
        $path = public_path('images/certificates/' . $filename);

        if (!file_exists($path)) {
            return null;
        }

        return base64_encode(file_get_contents($path));
    }

    protected function certificateLogos(): array
    {
        return [
            'kemnaker' => $this->imageBase64('logo-kemnaker.png'),
            'ymt' => $this->imageBase64('logo-ymt-creatorbase.png'),
            'vokasi' => $this->imageBase64('logo-pelatihan-vokasi.png'),
            'indonesia_skills' => $this->imageBase64('logo-indonesia-skills.png'),
            'siapkerja' => $this->imageBase64('logo-siapkerja.png'),
            'watermark' => $this->imageBase64('logo-blkk.png'),
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

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'class' => $class,
            'program' => $program,
            'participant' => $certificate->participant,
            'materials' => $materials,
            'degree' => $degree,
            'validityYears' => $validityYears,
            'qrDataUri' => $this->qrDataUri($qrPath),
            'logos' => $logos,
            'organization' => config('certificate.organization', 'YMT Creator Base BLKK Tanwiriyyah - Kementerian Ketenagakerjaan RI'),
            'organizationEn' => config('certificate.organization_en', 'BLKK Tanwiriyyah - Ministry of Manpower'),
            'directorName' => config('certificate.director_name', 'Zaid Ahmad, S.Kom.'),
            'directorTitleLine1' => config('certificate.director_title_line1', 'Direktur YMT Creator Base'),
            'directorTitleLine2' => config('certificate.director_title_line2', 'BLKK Tanwiriyyah'),
        ])->setPaper('a4', 'landscape');

        $path = 'certificates/pdf/' . $certificate->certificate_number . '.pdf';
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    public function downloadPath(Certificate $certificate): ?string
    {
        if (!$certificate->pdf_file || !Storage::disk('public')->exists($certificate->pdf_file)) {
            return null;
        }

        return Storage::disk('public')->path($certificate->pdf_file);
    }
}
