<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $materials = Material::where('class_id', $class->id)
            ->with('creator')
            ->orderBy('meeting_number')
            ->paginate(10);

        return view(
            'instruktur.materials.index',
            compact('class', 'materials')
        );
    }

    public function create(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        return view(
            'instruktur.materials.create',
            compact('class')
        );
    }

    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'meeting_number' => 'required|integer|min:1',
            'file' => 'nullable|file|max:102400', // 100MB max
            'youtube_url' => 'nullable|url|max:255',
        ]);

        // Check that at least one content is provided
        if (!$request->hasFile('file') && empty($validated['youtube_url'])) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => 'Please upload a file or provide a YouTube URL']);
        }

        $filePath = null;
        $fileType = null;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $fileType = $file->getClientOriginalExtension();
        }

        Material::create([
            'class_id' => $class->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'meeting_number' => $validated['meeting_number'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'youtube_url' => $validated['youtube_url'],
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('instruktur.materials.index', $class)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        $material->load('creator');

        return view(
            'instruktur.materials.show',
            compact('class', 'material')
        );
    }

    public function edit(ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        return view(
            'instruktur.materials.edit',
            compact('class', 'material')
        );
    }

    public function update(Request $request, ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'meeting_number' => 'required|integer|min:1',
            'file' => 'nullable|file|max:102400',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $filePath = $material->file_path;
        $fileType = $material->file_type;

        // Handle file upload if provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $fileType = $file->getClientOriginalExtension();
        }

        $material->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'meeting_number' => $validated['meeting_number'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'youtube_url' => $validated['youtube_url'],
        ]);

        return redirect()
            ->route('instruktur.materials.show', [$class, $material])
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        // Delete file if exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()
            ->route('instruktur.materials.index', $class)
            ->with('success', 'Materi berhasil dihapus.');
    }

    protected function authorizeInstructor(ClassModel $class)
    {
        if ($class->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
