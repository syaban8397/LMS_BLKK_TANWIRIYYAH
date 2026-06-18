<?php

namespace App\Services;

use App\Models\ClassModel;
use App\Models\SystemSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ReportPdfService
{
    public function __construct(protected ReportService $reportService) {}

    public function downloadParticipants(): Response
    {
        $rows = $this->reportService->participantsReport();

        return $this->download('admin.reports.pdf.participants', [
            'title' => __('lms.report.participants'),
            'rows' => $rows,
        ], 'laporan-peserta');
    }

    public function downloadInstructors(): Response
    {
        $rows = $this->reportService->instructorsReport();

        return $this->download('admin.reports.pdf.instructors', [
            'title' => __('lms.report.instructors'),
            'rows' => $rows,
        ], 'laporan-instruktur');
    }

    public function downloadClasses(): Response
    {
        $rows = $this->reportService->classesReport();

        return $this->download('admin.reports.pdf.classes', [
            'title' => __('lms.report.classes'),
            'rows' => $rows,
        ], 'laporan-kelas');
    }

    public function downloadClass(ClassModel $class): Response
    {
        $class->load(['program', 'instructor']);
        $students = $this->reportService->classParticipantStats($class);

        return $this->download('admin.reports.pdf.class-participants', [
            'title' => __('lms.report.classes') . ' - ' . $class->title,
            'class' => $class,
            'students' => $students,
        ], 'laporan-kelas-' . $class->code);
    }

    public function downloadAttendance(ClassModel $class): Response
    {
        $class->load(['program', 'instructor']);
        $report = $this->reportService->buildAttendanceMatrix($class);

        return $this->download('admin.reports.pdf.attendance', array_merge([
            'title' => __('lms.report.attendance') . ' - ' . $class->title,
            'class' => $class,
        ], $report), 'laporan-kehadiran-' . $class->code);
    }

    public function downloadGrades(): Response
    {
        $rows = $this->reportService->gradesReport();

        return $this->download('admin.reports.pdf.grades', [
            'title' => __('lms.report.grades'),
            'rows' => $rows,
        ], 'laporan-nilai');
    }

    public function downloadCertificates(): Response
    {
        $rows = $this->reportService->certificatesReport();

        return $this->download('admin.reports.pdf.certificates', [
            'title' => __('lms.report.certificates'),
            'rows' => $rows,
        ], 'laporan-sertifikat');
    }

    protected function download(string $view, array $data, string $basename): Response
    {
        $pdf = Pdf::loadView($view, array_merge($data, [
            'generatedAt' => now(),
            'appName' => SystemSetting::current()->appName(),
        ]))->setPaper('a4', 'landscape');

        return $pdf->download($basename . '-' . now()->format('Ymd') . '.pdf');
    }
}
