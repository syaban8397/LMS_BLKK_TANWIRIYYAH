<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ManagesClassCertificates;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    use ManagesClassCertificates;

    public function __construct(protected CertificateService $certificateService) {}

    public function index()
    {
        $classes = ClassModel::with(['program', 'instructor'])
            ->withCount('certificates')
            ->latest()
            ->paginate(10);

        return view('admin.certificates.index', compact('classes'));
    }

    public function show(ClassModel $class)
    {
        $class->load(['program', 'instructor']);
        $students = $this->certificateService->getClassStats($class);

        return view('admin.certificates.show', compact('class', 'students'));
    }

    public function saveStatuses(Request $request, ClassModel $class)
    {
        $count = $this->certificateService->bulkUpdateStatus(
            $class,
            $this->validatedCertificateStatuses($request)
        );

        return redirect()
            ->route('admin.certificates.show', $class)
            ->with('success', __('lms.flash.certificate_status_saved', ['count' => $count]));
    }

    public function bulkIssue(Request $request, ClassModel $class)
    {
        $participantIds = $this->resolveClassParticipantIds(
            $class,
            $this->validatedBulkIssueSelection($request)
        );

        if ($participantIds === []) {
            return redirect()
                ->route('admin.certificates.show', $class)
                ->with('error', __('lms.certificate_page.select_one_participant'));
        }

        return $this->redirectAfterBulkIssue(
            $class,
            $this->certificateService->bulkIssue($class, $participantIds),
            'admin.certificates.show'
        );
    }

    public function download(Certificate $certificate)
    {
        $path = $this->certificateService->downloadPath($certificate);

        if (!$path) {
            return redirect()
                ->route('admin.certificates.show', $certificate->class)
                ->with('error', __('lms.flash.certificate_file_not_found'));
        }

        return response()->download($path, $this->certificateService->downloadFilename($certificate));
    }

    public function destroy(ClassModel $class, Certificate $certificate)
    {
        return $this->destroyClassCertificate($class, $certificate, 'admin.certificates.show');
    }

    public function exportExcel(ClassModel $class)
    {
        return $this->exportClassCertificatesExcel($class);
    }
}
