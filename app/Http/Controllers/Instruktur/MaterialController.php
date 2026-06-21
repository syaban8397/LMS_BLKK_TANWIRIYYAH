<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\Instruktur\MaterialRequest;
use App\Models\ClassModel;
use App\Models\Material;
use App\Support\SecureStorage;

class MaterialController extends Controller
{
    use AuthorizesInstructorClass;
    use EnsuresNestedResourceBelongsToClass;

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

    public function store(MaterialRequest $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validated();

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

        $this->ensureBelongsToClass($material, $class);

        $material->load('creator');

        return view(
            'instruktur.materials.show',
            compact('class', 'material')
        );
    }

    public function edit(ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        $this->ensureBelongsToClass($material, $class);

        return view(
            'instruktur.materials.edit',
            compact('class', 'material')
        );
    }

    public function update(MaterialRequest $request, ClassModel $class, Material $material)
    {
        $this->authorizeInstructor($class);

        $this->ensureBelongsToClass($material, $class);

        $validated = $request->validated();

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

        $this->ensureBelongsToClass($material, $class);

        SecureStorage::delete($material->file_path);
        $material->delete();

        return redirect()
            ->route('instruktur.materials.index', $class)
            ->with('success', __('lms.flash.material_deleted'));
    }
}
