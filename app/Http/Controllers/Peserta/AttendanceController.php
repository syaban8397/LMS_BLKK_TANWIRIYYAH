<?php
// app/Http/Controllers/Peserta/AttendanceController.php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(ClassModel $class)
    {
        $this->authorizeParticipant($class);
        
        $attendances = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number', 'desc')
            ->get();
        
        return view('peserta.attendances.index', compact('class', 'attendances'));
    }
    
    public function show(ClassModel $class, $meetingNumber)
    {
        $this->authorizeParticipant($class);
        
        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();
        
        $canSubmit = Carbon::parse($attendance->attendance_date)->addDay()->isFuture();
        
        return view('peserta.attendances.show', compact('class', 'attendance', 'meetingNumber', 'canSubmit'));
    }
    
    public function submit(Request $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeParticipant($class);
        
        $validated = $request->validate([
            'status' => 'required|in:present,permission,sick',
            'notes' => 'nullable|string',
        ]);
        
        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();
        
        $canSubmit = Carbon::parse($attendance->attendance_date)->addDay()->isFuture();
        
        if (!$canSubmit) {
            return redirect()->back()->with('error', 'Attendance submission deadline has passed.');
        }
        
        if ($attendance->submission_type === 'instructor') {
            return redirect()->back()->with('error', 'Your attendance has been modified by instructor. Cannot change.');
        }
        
        $attendance->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'check_in_time' => now()->format('H:i:s'),
            'submission_type' => 'self',
            'updated_by' => auth()->id(),
        ]);
        
        return redirect()->route('peserta.attendances.index', $class)
            ->with('success', 'Attendance submitted successfully.');
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