<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index(ClassModel $class)
    {
        $this->authorizeStudent($class);

        $materials = Material::where('class_id', $class->id)
            ->with('creator')
            ->orderBy('meeting_number')
            ->paginate(10);

        return view(
            'peserta.materials.index',
            compact('class', 'materials')
        );
    }

    public function show(ClassModel $class, Material $material)
    {
        $this->authorizeStudent($class);

        if ($material->class_id !== $class->id) {
            abort(404);
        }

        $material->load('creator');

        return view(
            'peserta.materials.show',
            compact('class', 'material')
        );
    }

    protected function authorizeStudent(ClassModel $class)
    {
        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->exists();

        if (!$isEnrolled) {
            abort(403, 'You are not enrolled in this class');
        }
    }
}
