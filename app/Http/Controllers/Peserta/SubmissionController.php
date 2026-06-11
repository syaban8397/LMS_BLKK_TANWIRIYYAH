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

        if ($assignment->deadline->isPast() && !$submission) {
            return redirect()->route('peserta.assignments.show', [$class, $assignment])
                ->with('error', 'Deadline has passed. You cannot submit anymore.');
        }

        return view('peserta.submissions.create', compact('class', 'assignment', 'submission'));
    }

    public function store(Request $request, ClassModel $class, Assignment $assignment)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id) abort(404);
        if ($assignment->deadline->isPast()) return back()->with('error', 'Deadline has passed.');

        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('participant_id', auth()->id())
            ->first();
        if ($existing) {
            return redirect()->route('peserta.submissions.edit', [$class, $assignment, $existing])
                ->with('error', 'You already submitted. Please edit your submission.');
        }

        $validated = $request->validate([
            'url' => 'nullable|url',
            'file' => 'nullable|file|max:20480',
            'notes' => 'nullable|string',
        ]);

        if (empty($validated['url']) && !$request->hasFile('file')) {
            return back()->with('error', 'Please provide either a URL or upload a file.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', $fileName, 'public');
        }

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

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', 'Assignment submitted successfully.');
    }

    public function edit(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        if ($submission->isGraded()) return redirect()->route('peserta.assignments.show', [$class, $assignment])->with('error', 'Cannot edit graded submission.');
        if ($assignment->deadline->isPast()) return redirect()->route('peserta.assignments.show', [$class, $assignment])->with('error', 'Deadline has passed.');

        return view('peserta.submissions.edit', compact('class', 'assignment', 'submission'));
    }

    public function update(Request $request, ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        if ($submission->isGraded()) return back()->with('error', 'Cannot edit graded submission.');
        if ($assignment->deadline->isPast()) return back()->with('error', 'Deadline has passed.');

        $validated = $request->validate([
            'url' => 'nullable|url',
            'file' => 'nullable|file|max:20480',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($submission->file_path) Storage::disk('public')->delete($submission->file_path);
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $submission->file_path = $file->storeAs('submissions', $fileName, 'public');
        }

        $submission->url = $validated['url'] ?? $submission->url;
        $submission->notes = $validated['notes'] ?? $submission->notes;
        $submission->submitted_at = now();
        $submission->status = $assignment->deadline->isPast() ? 'late' : 'submitted';
        $submission->save();

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', 'Submission updated.');
    }

    public function destroy(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeStudent($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id || $submission->participant_id !== auth()->id()) abort(404);
        if ($submission->isGraded()) return back()->with('error', 'Cannot delete graded submission.');
        if ($submission->file_path) Storage::disk('public')->delete($submission->file_path);
        $submission->delete();

        return redirect()->route('peserta.assignments.show', [$class, $assignment])
            ->with('success', 'Submission deleted.');
    }

    protected function authorizeStudent(ClassModel $class)
    {
        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->exists();
        if (!$isEnrolled) abort(403, 'You are not enrolled in this class');
    }
}