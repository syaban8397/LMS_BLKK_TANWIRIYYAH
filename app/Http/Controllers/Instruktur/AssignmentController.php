<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;
use App\Support\SecureStorage;
use App\Support\UploadRules;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use AuthorizesInstructorClass;

    public function create(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        return view(
            'instruktur.assignments.create',
            compact('class')
        );
    }

    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'attachment' => UploadRules::documentAttachment(),
            'deadline' => 'required|date_format:Y-m-d\TH:i',
            'late_submission_allowed' => 'sometimes|boolean',
        ]);

        $deadline = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['deadline'])->format('Y-m-d H:i:s');

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = SecureStorage::storeUploadedFile($request->file('attachment'), 'assignments');
        }

        Assignment::create([
            'class_id' => $class->id,
            'created_by' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'attachment' => $attachmentPath,
            'deadline' => $deadline,
            'late_submission_allowed' => $request->boolean('late_submission_allowed'),
        ]);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.assignment_created'));
    }

    public function edit(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);

        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        return view(
            'instruktur.assignments.edit',
            compact('class', 'assignment')
        );
    }

    public function update(Request $request, ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);

        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'attachment' => UploadRules::documentAttachment(),
            'deadline' => 'required|date_format:Y-m-d\TH:i',
            'late_submission_allowed' => 'sometimes|boolean',
        ]);

        $attachmentPath = $assignment->attachment;
        if ($request->hasFile('attachment')) {
            SecureStorage::delete($assignment->attachment);
            $attachmentPath = SecureStorage::storeUploadedFile($request->file('attachment'), 'assignments');
        }

        $assignment->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'attachment' => $attachmentPath,
            'deadline' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['deadline'])->format('Y-m-d H:i:s'),
            'late_submission_allowed' => $request->boolean('late_submission_allowed'),
        ]);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.assignment_updated'));
    }

    public function destroy(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);

        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        SecureStorage::delete($assignment->attachment);
        $assignment->delete();

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.assignment_deleted'));
    }
}
