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

        // Get all content in chronological order
        $announcements = $class->announcements()->latest()->get();
        $materials = $class->materials()->orderBy('meeting_number')->get();
        $assignments = $class->assignments()->latest()->get();

        return view(
            'instruktur.classes.stream',
            compact('class', 'announcements', 'materials', 'assignments')
        );
    }
}
