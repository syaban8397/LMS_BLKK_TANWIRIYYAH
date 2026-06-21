<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Concerns\ValidatesAnnouncement;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use EnsuresNestedResourceBelongsToClass;
    use ValidatesAnnouncement;

    public function index()
    {
        $classes = ClassModel::with(['program', 'instructor'])
            ->withCount('announcements')
            ->latest()
            ->paginate(10);

        return view('admin.announcements.index', compact('classes'));
    }

    public function show(ClassModel $class)
    {
        $class->load(['program', 'instructor']);

        $announcements = Announcement::where('class_id', $class->id)
            ->with('creator')
            ->latest()
            ->get();

        return view('admin.announcements.show', compact('class', 'announcements'));
    }

    public function store(Request $request, ClassModel $class)
    {
        $validated = $this->validatedAnnouncement($request);

        Announcement::create([
            'class_id' => $class->id,
            'created_by' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()
            ->route('admin.announcements.show', $class)
            ->with('success', __('lms.flash.announcement_created'));
    }

    public function update(Request $request, ClassModel $class, Announcement $announcement)
    {
        $this->ensureBelongsToClass($announcement, $class);

        $validated = $this->validatedAnnouncement($request);

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.show', $class)
            ->with('success', __('lms.flash.announcement_updated'));
    }

    public function destroy(ClassModel $class, Announcement $announcement)
    {
        $this->ensureBelongsToClass($announcement, $class);

        $announcement->delete();

        return redirect()
            ->route('admin.announcements.show', $class)
            ->with('success', __('lms.flash.announcement_deleted'));
    }
}
