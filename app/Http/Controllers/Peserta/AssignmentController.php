<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    use AuthorizesActiveEnrollment;
    use EnsuresNestedResourceBelongsToClass;

    public function index(ClassModel $class)
    {
        $this->authorizeActiveStudent($class);
        $assignments = $class->assignments()
            ->where('is_active', true)
            ->with([
                'submissions' => fn ($query) => $query->where('participant_id', auth()->id()),
            ])
            ->latest()
            ->paginate(10);

        return view('peserta.assignments.index', compact('class', 'assignments'));
    }

    public function show(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeActiveStudent($class);

        $this->ensureBelongsToClass($assignment, $class);

        if (!$assignment->is_active) {
            abort(404);
        }

        $assignment->load([
            'creator',
            'submissions' => fn ($query) => $query->where('participant_id', auth()->id()),
        ]);

        return view('peserta.assignments.show', compact('class', 'assignment'));
    }
}
