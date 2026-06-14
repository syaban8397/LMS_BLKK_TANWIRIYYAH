<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ClassModel;

trait AuthorizesInstructorClass
{
    protected function authorizeInstructor(ClassModel $class): void
    {
        if ($class->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
