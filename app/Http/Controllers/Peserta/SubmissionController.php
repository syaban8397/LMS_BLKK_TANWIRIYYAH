<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\Submission;
use App\Support\SecureStorage;
use App\Http\Requests\Peserta\SubmissionRequest;

class SubmissionController extends Controller
{
    use AuthorizesActiveEnrollment;
    use EnsuresNestedResourceBelongsToClass;

    public function create(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeActiveStudent($class);
        $this->ensureActiveAssignmentInClass($assignment, $class);

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('participant_id', auth()->id())
            ->first();

        if ($submission) {
            return redirect()->route('peserta.submissions.edit', [$class, $assignment, $submission])
                ->with('info', __('lms.flash.submission_has_existing'));
        }

        if (!$assignment->allowsSubmission()) {
            return redirect()->route('peserta.assignments.show', [$class, $assignment])
                ->with('error', __('lms.flash.submission_deadline_passed'));
        }

        return view('peserta.submissions.create', compact('class', 'assignment', 'submission'));
    }

    public function store(SubmissionRequest $request, ClassModel $class, Assignment $assignment)
    {
        $this->authorizeActiveStudent($class);
        $this->ensureActiveAssignmentInClass($assignment, $class);

        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('participant_id', auth()->id())
            ->first();

        if ($existing) {
            return redirect()->route('peserta.submissions.edit', [$class, $assignment, $existing])
                ->with('error', __('lms.flash.submission_already_submitted'));
        }

        if (!$assignment->allowsSubmission()) {
            return back()->with('error', __('lms.flash.submission_deadline_passed'));
        }

        $validated = $request->validated();

        if (empty($validated['url']) && !$request->hasFile('file')) {
            return back()->with('error', __('lms.flash.submission_need_url_or_file'));
        }

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = SecureStorage::storeUploadedFile($request->file('file'), 'submissions');
        }

        $status = $assignment->deadline->isPast() ? 'late' : 'submitted';

        try {
            Submission::create([
                'assignment_id' => $assignment->id,
                'participant_id' => auth()->id(),
                'url' => $validated['url'] ?? null,
                'file_path' => $filePath,
                'notes' => $validated['notes'] ?? null,
                'submitted_at' => now(),
                'status' => $status,
            ]);
        } catch (UniqueConstraintViolationException $e) {
            $existing = Submission::where('assignment_id', $assignment->id)
                ->where('participant_id', auth()->id())
                ->first();

            if ($existing) {
                return redirect()->route('peserta.submissions.edit', [$class, $assignment, $existing])
                    ->with('error', __('lms.flash.submission_already_submitted'));
            }

            throw $e;
        }

        $message = $status === 'late'
            ? __('lms.flash.submission_created_late')
            : __('lms.flash.submission_created');

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', $message);
    }

    public function edit(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeActiveStudent($class);
        $this->ensureOwnSubmission($assignment, $class, $submission);

        if ($submission->isGraded()) {
            return redirect()->route('peserta.assignments.show', [$class, $assignment])
                ->with('error', __('lms.flash.submission_cannot_edit_graded'));
        }

        if (!$assignment->allowsSubmission()) {
            return redirect()->route('peserta.assignments.show', [$class, $assignment])
                ->with('error', __('lms.flash.submission_deadline_passed'));
        }

        return view('peserta.submissions.edit', compact('class', 'assignment', 'submission'));
    }

    public function update(SubmissionRequest $request, ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeActiveStudent($class);
        $this->ensureOwnSubmission($assignment, $class, $submission);

        if ($submission->isGraded()) {
            return back()->with('error', __('lms.flash.submission_cannot_edit_graded'));
        }

        if (!$assignment->allowsSubmission()) {
            return back()->with('error', __('lms.flash.submission_deadline_passed'));
        }

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            SecureStorage::delete($submission->file_path);
            $submission->file_path = SecureStorage::storeUploadedFile($request->file('file'), 'submissions');
        }

        $submission->url = $validated['url'] ?? $submission->url;
        $submission->notes = $validated['notes'] ?? $submission->notes;
        $submission->submitted_at = now();
        $submission->status = $assignment->deadline->isPast() ? 'late' : 'submitted';
        $submission->save();

        $message = $submission->status === 'late'
            ? __('lms.flash.submission_updated_late')
            : __('lms.flash.submission_updated');

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', $message);
    }

    public function destroy(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeActiveStudent($class);
        $this->ensureOwnSubmission($assignment, $class, $submission);

        if ($submission->isGraded()) {
            return back()->with('error', __('lms.flash.submission_cannot_delete_graded'));
        }

        if (!$assignment->allowsSubmission()) {
            return back()->with('error', __('lms.flash.submission_cannot_delete_after_deadline'));
        }

        SecureStorage::delete($submission->file_path);
        $submission->delete();

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', __('lms.flash.submission_deleted'));
    }

    protected function ensureActiveAssignmentInClass(Assignment $assignment, ClassModel $class): void
    {
        $this->ensureBelongsToClass($assignment, $class);

        if (!$assignment->is_active) {
            abort(404);
        }
    }

    protected function ensureOwnSubmission(Assignment $assignment, ClassModel $class, Submission $submission): void
    {
        $this->ensureBelongsToClass($assignment, $class);

        if ($submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) {
            abort(404);
        }
    }
}
