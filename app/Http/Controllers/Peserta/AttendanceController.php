<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(ClassModel $class)
    {
        $this->authorizeParticipant($class);
        
        $attendances = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number')
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
        
        $isExpired = now()->gt($attendance->attendance_deadline);
        
        return view('peserta.attendances.show', compact('class', 'attendance', 'meetingNumber', 'isExpired'));
    }
    
    public function submit(Request $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeParticipant($class);
        
        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();
        
        if ($attendance->submission_type === 'instructor') {
            return redirect()->back()->with('error', __('lms.flash.attendance_locked'));
        }

        if (now()->gt($attendance->attendance_deadline)) {
            return redirect()->back()->with('error', __('lms.flash.attendance_deadline_passed'));
        }
        if (now()->lt($attendance->attendance_date)) {
            return redirect()->back()->with('error', __('lms.flash.attendance_not_started'));
        }
        $request->validate([
            'status' => 'required|in:present,permission,sick',
            'notes'  => 'nullable|string|max:255',
        ]);
        
        $attendance->update([
            'status'          => $request->status,
            'notes'           => $request->notes,
            'check_in_time'   => now(),
            'submission_type' => 'self',
            'updated_by'      => auth()->id(),
        ]);
        
        return redirect()->route('peserta.attendances.index', $class)
            ->with('success', __('lms.flash.attendance_saved'));
    }
    
    protected function authorizeParticipant(ClassModel $class)
    {
        $isParticipant = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('status', 'active')
            ->exists();
        
        if (!$isParticipant) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }
    }
}
