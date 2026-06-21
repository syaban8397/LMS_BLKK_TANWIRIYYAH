<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\RedirectResponse;

class MaterialController extends Controller
{
    use AuthorizesActiveEnrollment;
    use EnsuresNestedResourceBelongsToClass;

    public function index(ClassModel $class)
    {
        $this->authorizeActiveStudent($class);

        $materials = Material::where('class_id', $class->id)
            ->with('creator')
            ->orderBy('meeting_number')
            ->paginate(10);

        $progressMap = MaterialProgress::where('participant_id', auth()->id())
            ->whereIn('material_id', $materials->pluck('id'))
            ->pluck('status', 'material_id');

        return view('peserta.materials.index', compact('class', 'materials', 'progressMap'));
    }

    public function show(ClassModel $class, Material $material)
    {
        $this->authorizeActiveStudent($class);

        $this->ensureBelongsToClass($material, $class);

        $material->load('creator');

        $progress = MaterialProgress::firstOrCreate(
            [
                'material_id' => $material->id,
                'participant_id' => auth()->id(),
            ],
            ['status' => 'not_started']
        );

        return view('peserta.materials.show', compact('class', 'material', 'progress'));
    }

    public function complete(ClassModel $class, Material $material): RedirectResponse
    {
        $this->authorizeActiveStudent($class);

        $this->ensureBelongsToClass($material, $class);

        MaterialProgress::updateOrCreate(
            [
                'material_id' => $material->id,
                'participant_id' => auth()->id(),
            ],
            [
                'status' => 'completed',
                'completed_at' => now(),
            ]
        );

        return back()->with('success', __('lms.flash.material_completed'));
    }
}
