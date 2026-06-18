<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ClassModel;
use App\Models\ClassParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait ManagesClassCertificates
{
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
}
