<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;

class ClassController extends Controller
{
    use AuthorizesActiveEnrollment;

    public function index()
    {
        $enrolledClasses = \App\Models\ClassParticipant::where('participant_id', auth()->id())
            ->with(['class.program', 'class.instructor'])
            ->latest()
            ->paginate(10);

        $totalClasses = \App\Models\ClassParticipant::where('participant_id', auth()->id())->count();

        $activeClasses = \App\Models\ClassParticipant::where('participant_id', auth()->id())
            ->where('status', 'active')
            ->count();

        $completedClasses = \App\Models\ClassParticipant::where('participant_id', auth()->id())
            ->where('status', 'completed')
            ->count();

        return view(
            'peserta.classes.index',
            compact(
                'enrolledClasses',
                'totalClasses',
                'activeClasses',
                'completedClasses'
            )
        );
    }

    public function show(ClassModel $class)
    {
        $this->authorizeActiveStudent($class);

        $class->load(['program', 'instructor']);

        $participation = \App\Models\ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();

        $announcements = $class->announcements()
            ->with('creator')
            ->latest()
            ->get();

        return view(
            'peserta.classes.show',
            compact('class', 'participation', 'announcements')
        );
    }
}
