<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Concerns\ValidatesAnnouncement;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use AuthorizesInstructorClass;
    use ValidatesAnnouncement;

    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $this->validatedAnnouncement($request);

        Announcement::create([
            'class_id' => $class->id,
            'created_by' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.announcement_created'));
    }

    public function edit(ClassModel $class, Announcement $announcement)
    {
        $this->authorizeInstructor($class);

        if ($announcement->class_id !== $class->id) {
            abort(404);
        }

        return response()->json([
            'id' => $announcement->id,
            'title' => $announcement->title,
            'description' => $announcement->description,
        ]);
    }

    public function update(Request $request, ClassModel $class, Announcement $announcement)
    {
        $this->authorizeInstructor($class);

        if ($announcement->class_id !== $class->id) {
            abort(404);
        }

        $validated = $this->validatedAnnouncement($request);

        $announcement->update($validated);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.announcement_updated'));
    }

    public function destroy(ClassModel $class, Announcement $announcement)
    {
        $this->authorizeInstructor($class);

        if ($announcement->class_id !== $class->id) {
            abort(404);
        }

        $announcement->delete();

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', __('lms.flash.announcement_deleted'));
    }
}
