<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Services\CertificateService;
use App\Exports\ClassCertificateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $certificateService) {}

    public function index()
    {
        $classes = ClassModel::where('instructor_id', auth()->id())
            ->with(['program'])
            ->withCount('certificates')
            ->latest()
            ->paginate(10);

        return view('instruktur.certificates.index', compact('classes'));
    }

    public function show(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        $class->load(['program', 'instructor']);
        $students = $this->certificateService->getClassStats($class);

        return view('instruktur.certificates.show', compact('class', 'students'));
    }

    public function saveStatuses(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'status' => 'nullable|array',
            'status.*' => 'in:pass,fail',
        ]);

        $statuses = array_filter(
            $validated['status'] ?? [],
            fn ($status) => in_array($status, ['pass', 'fail'], true)
        );

        $count = $this->certificateService->bulkUpdateStatus($class, $statuses);

        return redirect()
            ->route('instruktur.certificates.show', $class)
            ->with('success', "Status {$count} peserta berhasil disimpan.");
    }

    public function bulkIssue(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'selected' => 'required|array|min:1',
            'selected.*' => 'integer',
        ]);

        $participantIds = ClassParticipant::where('class_id', $class->id)
            ->whereIn('participant_id', $validated['selected'])
            ->pluck('participant_id')
            ->all();

        $result = $this->certificateService->bulkIssue($class, $participantIds);

        $message = count($result['issued']) . ' sertifikat berhasil diterbitkan.';
        if (!empty($result['errors'])) {
            return redirect()
                ->route('instruktur.certificates.show', $class)
                ->with('success', $message)
                ->with('error', implode(' ', array_unique($result['errors'])));
        }

        return redirect()
            ->route('instruktur.certificates.show', $class)
            ->with('success', $message);
    }

    public function download(Certificate $certificate)
    {
        $certificate->load('class');

        if ($certificate->class->instructor_id !== auth()->id()) {
            abort(403);
        }

        $path = $this->certificateService->downloadPath($certificate);

        if (!$path) {
            abort(404, 'File sertifikat tidak ditemukan.');
        }

        return response()->download($path, $certificate->certificate_number . '.pdf');
    }

    public function exportExcel(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        $class->load(['program', 'instructor']);
        $students = $this->certificateService->getClassStats($class);
        $filename = 'laporan-sertifikat-' . $class->code . '-' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new ClassCertificateExport($class, $students), $filename);
    }

    protected function authorizeInstructor(ClassModel $class)
    {
        if ($class->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
