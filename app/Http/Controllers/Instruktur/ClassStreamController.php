<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;

class ClassStreamController extends Controller
{
    use AuthorizesInstructorClass;

    public function stream(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $class->load(['program', 'instructor', 'participants']);

        $announcements = $class->announcements()->with('creator')->latest()->get();
        $materials = $class->materials()->with('creator')->orderBy('meeting_number')->get();
        $assignments = $class->assignments()->with(['creator', 'submissions'])->latest()->get();

        return view(
            'instruktur.classes.stream',
            compact('class', 'announcements', 'materials', 'assignments')
        );
    }
}
