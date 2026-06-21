<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Concerns\ManagesClassCertificates;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    use AuthorizesInstructorClass;
    use ManagesClassCertificates;

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

        $count = $this->certificateService->bulkUpdateStatus(
            $class,
            $this->validatedCertificateStatuses($request)
        );

        return redirect()
            ->route('instruktur.certificates.show', $class)
            ->with('success', __('lms.flash.certificate_status_saved', ['count' => $count]));
    }

    public function bulkIssue(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $participantIds = $this->resolveClassParticipantIds(
            $class,
            $this->validatedBulkIssueSelection($request)
        );

        if ($participantIds === []) {
            return redirect()
                ->route('instruktur.certificates.show', $class)
                ->with('error', __('lms.certificate_page.select_one_participant'));
        }

        return $this->redirectAfterBulkIssue(
            $class,
            $this->certificateService->bulkIssue($class, $participantIds),
            'instruktur.certificates.show'
        );
    }

    public function download(Certificate $certificate)
    {
        $certificate->load('class');

        if ($certificate->class->instructor_id !== auth()->id()) {
            abort(403);
        }

        $path = $this->certificateService->downloadPath($certificate);

        if (!$path) {
            return redirect()
                ->route('instruktur.certificates.show', $certificate->class)
                ->with('error', __('lms.flash.certificate_file_not_found'));
        }

        return response()->download($path, $this->certificateService->downloadFilename($certificate));
    }

    public function destroy(ClassModel $class, Certificate $certificate)
    {
        $this->authorizeInstructor($class);

        return $this->destroyClassCertificate($class, $certificate, 'instruktur.certificates.show');
    }

    public function exportExcel(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        return $this->exportClassCertificatesExcel($class);
    }
}
