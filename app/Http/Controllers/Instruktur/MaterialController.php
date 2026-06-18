<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Material;
use App\Support\SecureStorage;
use App\Support\UploadRules;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    use AuthorizesInstructorClass;

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
            'material_code' => 'nullable|max:50',
            'description' => 'nullable|string',
            'meeting_number' => 'required|integer|min:1',
            'file' => UploadRules::documentAttachment(),
            'youtube_url' => 'nullable|url|max:255',
        ]);

        if (!$request->hasFile('file') && empty($validated['youtube_url'])) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => __('lms.flash.material_need_content')]);
        }

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = SecureStorage::storeUploadedFile($file, 'materials');
            $fileType = $file->getClientOriginalExtension();
        }

        Material::create([
            'class_id' => $class->id,
            'title' => $validated['title'],
            'material_code' => $validated['material_code'] ?? null,
            'description' => $validated['description'],
            'meeting_number' => $validated['meeting_number'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'youtube_url' => $validated['youtube_url'],
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('instruktur.materials.index', $class)
            ->with('success', __('lms.flash.material_created'));
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
            'material_code' => 'nullable|max:50',
            'description' => 'nullable|string',
            'meeting_number' => 'required|integer|min:1',
            'file' => UploadRules::documentAttachment(),
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $filePath = $material->file_path;
        $fileType = $material->file_type;

        if ($request->hasFile('file')) {
            SecureStorage::delete($material->file_path);

            $file = $request->file('file');
            $filePath = SecureStorage::storeUploadedFile($file, 'materials');
            $fileType = $file->getClientOriginalExtension();
        }

        $material->update([
            'title' => $validated['title'],
            'material_code' => $validated['material_code'] ?? null,
            'description' => $validated['description'],
            'meeting_number' => $validated['meeting_number'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'youtube_url' => $validated['youtube_url'],
        ]);

        return redirect()
            ->route('instruktur.materials.show', [$class, $material])
            ->with('success', __('lms.flash.material_updated'));
    }

    public function destroy(ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        SecureStorage::delete($material->file_path);
        $material->delete();

        return redirect()
            ->route('instruktur.materials.index', $class)
            ->with('success', __('lms.flash.material_deleted'));
    }
}
