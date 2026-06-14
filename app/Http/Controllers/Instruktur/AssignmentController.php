<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:102400',
        'deadline' => 'required|date_format:Y-m-d\TH:i',
        'late_submission_allowed' => 'sometimes|boolean', // TAMBAHKAN
    ]);

    $deadline = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['deadline'])->format('Y-m-d H:i:s');

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $attachmentPath = $file->storeAs('assignments', $fileName, 'public');
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
        ->with('success', 'Assignment berhasil dibuat.');
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
        'attachment' => 'nullable|file|max:102400',
        'deadline' => 'required|date_format:Y-m-d\TH:i',
        'late_submission_allowed' => 'sometimes|boolean', // TAMBAHKAN
    ]);

    $attachmentPath = $assignment->attachment;
    if ($request->hasFile('attachment')) {
        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }
        $file = $request->file('attachment');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $attachmentPath = $file->storeAs('assignments', $fileName, 'public');
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
        ->with('success', 'Assignment berhasil diperbarui.');
}

    public function destroy(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);

        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }

        $assignment->delete();

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', 'Assignment berhasil dihapus.');
    }
}
