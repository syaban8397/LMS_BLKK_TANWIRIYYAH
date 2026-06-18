<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ClassModel;
use App\Models\ClassParticipant;

trait AuthorizesActiveEnrollment
{
    protected function authorizeActiveStudent(ClassModel $class): void
    {
        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        if (!$isEnrolled) {
            abort(403, __('lms.access.not_enrolled'));
        }
    }
}
