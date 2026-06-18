<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Reports\AttendanceReportExport;
use App\Exports\Reports\CertificatesReportExport;
use App\Exports\Reports\ClassesReportExport;
use App\Exports\Reports\ClassParticipantsReportExport;
use App\Exports\Reports\GradesReportExport;
use App\Exports\Reports\InstructorsReportExport;
use App\Exports\Reports\ParticipantsReportExport;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Services\ReportService;
use App\Services\ReportPdfService;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService,
        protected ReportPdfService $reportPdfService
    ) {}

    public function index()
    {
        return view('admin.reports.index');
    }

    public function participants()
    {
        $participants = $this->reportService->participantsReport();

        return view('admin.reports.participants', compact('participants'));
    }

    public function exportParticipants()
    {
        $participants = $this->reportService->participantsReport();

        return Excel::download(
            new ParticipantsReportExport($participants),
            'laporan-peserta-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportParticipantsPdf()
    {
        return $this->reportPdfService->downloadParticipants();
    }

    public function instructors()
    {
        $instructors = $this->reportService->instructorsReport();

        return view('admin.reports.instructors', compact('instructors'));
    }

    public function exportInstructors()
    {
        $instructors = $this->reportService->instructorsReport();

        return Excel::download(
            new InstructorsReportExport($instructors),
            'laporan-instruktur-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportInstructorsPdf()
    {
        return $this->reportPdfService->downloadInstructors();
    }

    public function classes()
    {
        $classes = $this->reportService->classesReport();

        return view('admin.reports.classes', compact('classes'));
    }

    public function showClass(ClassModel $class)
    {
        $class->load(['program', 'instructor']);
        $students = $this->reportService->classParticipantStats($class);

        return view('admin.reports.class-show', compact('class', 'students'));
    }

    public function exportClasses()
    {
        $classes = $this->reportService->classesReport();

        return Excel::download(
            new ClassesReportExport($classes),
            'laporan-kelas-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportClassesPdf()
    {
        return $this->reportPdfService->downloadClasses();
    }

    public function exportClass(ClassModel $class)
    {
        $class->load(['program', 'instructor']);
        $students = $this->reportService->classParticipantStats($class);

        return Excel::download(
            new ClassParticipantsReportExport($class, $students),
            'laporan-kelas-' . $class->code . '-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportClassPdf(ClassModel $class)
    {
        return $this->reportPdfService->downloadClass($class);
    }

    public function attendance()
    {
        $classes = ClassModel::with(['program', 'instructor'])->latest()->paginate(10);

        return view('admin.reports.attendance', compact('classes'));
    }

    public function showAttendance(ClassModel $class)
    {
        $class->load(['program', 'instructor']);
        $report = $this->reportService->buildAttendanceMatrix($class);

        return view('admin.reports.attendance-show', array_merge(compact('class'), $report));
    }

    public function exportAttendance(ClassModel $class)
    {
        $class->load(['program', 'instructor']);
        $report = $this->reportService->buildAttendanceMatrix($class);

        return Excel::download(
            new AttendanceReportExport($class, $report['meetings'], $report['attendanceMatrix']),
            'laporan-kehadiran-' . $class->code . '-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportAttendancePdf(ClassModel $class)
    {
        return $this->reportPdfService->downloadAttendance($class);
    }

    public function grades()
    {
        $grades = $this->reportService->gradesReport();

        return view('admin.reports.grades', compact('grades'));
    }

    public function exportGrades()
    {
        $grades = $this->reportService->gradesReport();

        return Excel::download(
            new GradesReportExport($grades),
            'laporan-nilai-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportGradesPdf()
    {
        return $this->reportPdfService->downloadGrades();
    }

    public function certificates()
    {
        $certificates = $this->reportService->certificatesReport();

        return view('admin.reports.certificates', compact('certificates'));
    }

    public function exportCertificates()
    {
        $certificates = $this->reportService->certificatesReport();

        return Excel::download(
            new CertificatesReportExport($certificates),
            'laporan-sertifikat-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function exportCertificatesPdf()
    {
        return $this->reportPdfService->downloadCertificates();
    }
}
