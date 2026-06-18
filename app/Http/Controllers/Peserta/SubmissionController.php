<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function create(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id) abort(404);

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('participant_id', auth()->id())
            ->first();

        // Jika sudah ada submission, redirect ke edit
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

    public function store(Request $request, ClassModel $class, Assignment $assignment)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id) abort(404);

        // Cek apakah sudah ada submission
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

        $validated = $request->validate([
            'url' => 'nullable|url',
            'file' => 'nullable|file|max:20480', // 20MB max
            'notes' => 'nullable|string',
        ]);

        if (empty($validated['url']) && !$request->hasFile('file')) {
            return back()->with('error', __('lms.flash.submission_need_url_or_file'));
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('submissions', $fileName, 'public');
        }

        // Tentukan status berdasarkan deadline
        $status = $assignment->deadline->isPast() ? 'late' : 'submitted';

        Submission::create([
            'assignment_id' => $assignment->id,
            'participant_id' => auth()->id(),
            'url' => $validated['url'] ?? null,
            'file_path' => $filePath,
            'notes' => $validated['notes'] ?? null,
            'submitted_at' => now(),
            'status' => $status,
        ]);

        $message = $status === 'late'
            ? __('lms.flash.submission_created_late')
            : __('lms.flash.submission_created');

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', $message);
    }

    public function edit(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        
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

    public function update(Request $request, ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        
        if ($submission->isGraded()) {
            return back()->with('error', __('lms.flash.submission_cannot_edit_graded'));
        }
        
        if (!$assignment->allowsSubmission()) {
            return back()->with('error', __('lms.flash.submission_deadline_passed'));
        }

        $validated = $request->validate([
            'url' => 'nullable|url',
            'file' => 'nullable|file|max:20480',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $submission->file_path = $file->storeAs('submissions', $fileName, 'public');
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
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        
        if ($submission->isGraded()) {
            return back()->with('error', __('lms.flash.submission_cannot_delete_graded'));
        }

        if (!$assignment->allowsSubmission()) {
            return back()->with('error', __('lms.flash.submission_cannot_delete_after_deadline'));
        }
        
        if ($submission->file_path) {
            Storage::disk('public')->delete($submission->file_path);
        }
        
        $submission->delete();

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', __('lms.flash.submission_deleted'));
    }

    protected function authorizeStudent(ClassModel $class)
    {
        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->exists();
        if (!$isEnrolled) abort(403, 'You are not enrolled in this class');
    }
}