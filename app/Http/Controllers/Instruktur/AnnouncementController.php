<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        Announcement::create([
            'class_id' => $class->id,
            'created_by' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', 'Pengumuman berhasil ditambahkan.');
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

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $announcement->update($validated);

        return redirect()
            ->route('instruktur.classes.stream', $class)
            ->with('success', 'Pengumuman berhasil diperbarui.');
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
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    protected function authorizeInstructor(ClassModel $class)
    {
        if ($class->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
