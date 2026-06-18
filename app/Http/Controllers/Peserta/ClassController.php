<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $enrolledClasses = ClassParticipant::where('participant_id', auth()->id())
            ->with(['class.program', 'class.instructor'])
            ->latest()
            ->paginate(10);

        $totalClasses = ClassParticipant::where('participant_id', auth()->id())->count();

        $activeClasses = ClassParticipant::where('participant_id', auth()->id())
            ->where('status', 'active')
            ->count();

        $completedClasses = ClassParticipant::where('participant_id', auth()->id())
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
        $this->authorizeStudent($class);

        $class->load(['program', 'instructor']);

        $participation = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
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
