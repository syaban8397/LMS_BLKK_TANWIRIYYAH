<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;
use App\Models\ClassParticipant;

class AssignmentController extends Controller
{
    // Daftar semua assignment di kelas ini
    public function index(ClassModel $class)
    {
        $this->authorizeStudent($class);
        $assignments = $class->assignments()->with('submissions')->latest()->paginate(10);
        return view('peserta.assignments.index', compact('class', 'assignments'));
    }

    // Detail assignment + form submit
    public function show(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeStudent($class);

        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        $assignment->load('creator', 'submissions');

        return view('peserta.assignments.show', compact('class', 'assignment'));
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