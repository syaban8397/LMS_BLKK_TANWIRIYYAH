<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;

class ClassStreamController extends Controller
{
    use AuthorizesActiveEnrollment;

    public function stream(ClassModel $class)
    {
        $this->authorizeActiveStudent($class);

        $class->load(['program', 'instructor']);

        $announcements = $class->announcements()->with('creator')->latest()->get();
        $materials = $class->materials()->with('creator')->orderBy('meeting_number')->get();
        $assignments = $class->assignments()
            ->where('is_active', true)
            ->with([
                'creator',
                'submissions' => fn ($query) => $query->where('participant_id', auth()->id()),
            ])
            ->latest()
            ->get();

        $attendances = \App\Models\Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number', 'desc')
            ->get();

        return view('peserta.classes.stream', compact('class', 'announcements', 'materials', 'assignments', 'attendances'));
    }
}
