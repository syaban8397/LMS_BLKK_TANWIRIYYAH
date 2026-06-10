<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;

class ClassStreamController extends Controller
{
    public function stream(ClassModel $class)
    {
        $this->authorizeParticipant($class);
        
        $class->load(['program', 'instructor']);
        
        $announcements = $class->announcements()->latest()->get();
        $materials = $class->materials()->orderBy('meeting_number')->get();
        $assignments = $class->assignments()->latest()->get();
        
        // Add attendances for current participant
        $attendances = \App\Models\Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number', 'desc')
            ->get();
        
        return view('peserta.classes.stream', compact('class', 'announcements', 'materials', 'assignments', 'attendances'));
    }
    
    protected function authorizeParticipant(ClassModel $class)
    {
        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('status', 'active')
            ->exists();
        
        if (!$isEnrolled) {
            abort(403, 'You are not enrolled in this class.');
        }
    }
}