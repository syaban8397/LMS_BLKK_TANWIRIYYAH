<?php

namespace App\Http\Controllers\Concerns;

use App\Exports\ClassCertificateExport;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait ManagesClassCertificates
{
    use EnsuresNestedResourceBelongsToClass;
    protected function validatedCertificateStatuses(Request $request): array
    {
        $validated = $request->validate([
            'status' => 'nullable|array',
            'status.*' => 'in:pass,fail',
        ]);

        return array_filter(
            $validated['status'] ?? [],
            fn ($status) => in_array($status, ['pass', 'fail'], true)
        );
    }

    protected function validatedBulkIssueSelection(Request $request): array
    {
        $validated = $request->validate([
            'selected' => 'required|array|min:1',
            'selected.*' => 'integer',
        ]);

        return $validated['selected'];
    }

    protected function resolveClassParticipantIds(ClassModel $class, array $selected): array
    {
        return ClassParticipant::where('class_id', $class->id)
            ->whereIn('participant_id', $selected)
            ->pluck('participant_id')
            ->all();
    }

    protected function redirectAfterBulkIssue(
        ClassModel $class,
        array $result,
        string $showRoute
    ): RedirectResponse {
        $message = __('lms.flash.certificates_issued', ['count' => count($result['issued'])]);

        if (!empty($result['errors'])) {
            return redirect()
                ->route($showRoute, $class)
                ->with('success', $message)
                ->with('error', implode(' ', array_unique($result['errors'])));
        }

        return redirect()
            ->route($showRoute, $class)
            ->with('success', $message);
    }

    protected function certificateExportFilename(ClassModel $class): string
    {
        return 'laporan-sertifikat-' . $class->code . '-' . now()->format('Ymd') . '.xlsx';
    }

    protected function destroyClassCertificate(
        ClassModel $class,
        Certificate $certificate,
        string $showRoute
    ): RedirectResponse {
        $this->ensureBelongsToClass($certificate, $class);

        if (!$certificate->pdf_file) {
            return redirect()
                ->route($showRoute, $class)
                ->with('error', __('lms.flash.certificate_not_issued'));
        }

        $certificate->load('participant');
        $participantName = $certificate->participant?->name ?? __('lms.certificate_page.participant');
        $this->certificateService->delete($certificate);

        return redirect()
            ->route($showRoute, $class)
            ->with('success', __('lms.flash.certificate_deleted', ['name' => $participantName]));
    }

    protected function exportClassCertificatesExcel(ClassModel $class): BinaryFileResponse
    {
        $class->load(['program', 'instructor']);
        $students = $this->certificateService->getClassStats($class);

        return Excel::download(
            new ClassCertificateExport($class, $students),
            $this->certificateExportFilename($class)
        );
    }
}
