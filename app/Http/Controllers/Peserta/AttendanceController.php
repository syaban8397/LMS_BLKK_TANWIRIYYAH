<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Concerns\AuthorizesActiveEnrollment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\SubmitAttendanceRequest;
use App\Models\Attendance;
use App\Models\ClassModel;

class AttendanceController extends Controller
{
    use AuthorizesActiveEnrollment;

    public function index(ClassModel $class)
    {
        $this->authorizeActiveStudent($class);

        $attendances = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number')
            ->get();

        return view('peserta.attendances.index', compact('class', 'attendances'));
    }

    public function show(ClassModel $class, $meetingNumber)
    {
        $this->authorizeActiveStudent($class);

        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();

        $isExpired = now()->gt($attendance->attendance_deadline);

        return view('peserta.attendances.show', compact('class', 'attendance', 'meetingNumber', 'isExpired'));
    }

    public function submit(SubmitAttendanceRequest $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeActiveStudent($class);

        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();

        if ($attendance->submission_type === 'instructor') {
            return redirect()->back()->with('error', __('lms.flash.attendance_locked'));
        }

        if (now()->gt($attendance->attendance_deadline)) {
            return redirect()->back()->with('error', __('lms.flash.attendance_window_closed'));
        }

        if (now()->lt($attendance->attendance_date)) {
            return redirect()->back()->with('error', __('lms.flash.attendance_window_not_open'));
        }

        $validated = $request->validated();

        $attendance->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'check_in_time' => now(),
            'submission_type' => 'self',
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('peserta.attendances.index', $class)
            ->with('success', __('lms.flash.attendance_saved'));
    }
}
