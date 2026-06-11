<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Daftar semua sesi absensi untuk kelas tertentu (peserta)
    public function index(ClassModel $class)
    {
        $this->authorizeParticipant($class);
        
        $attendances = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->orderBy('meeting_number')
            ->get();
        
        return view('peserta.attendances.index', compact('class', 'attendances'));
    }
    
    // Form atau halaman detail untuk submit absensi
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
    
    // Proses submit absensi oleh peserta
    public function submit(Request $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeParticipant($class);
        
        $attendance = Attendance::where('class_id', $class->id)
            ->where('participant_id', auth()->id())
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();
        
        // Validasi deadline
        if (now()->gt($attendance->attendance_deadline)) {
            return redirect()->back()->with('error', 'Maaf, waktu absensi sudah habis. Silakan hubungi instruktur.');
        }
        
        $request->validate([
            'status' => 'required|in:present,permission,sick', // peserta tidak bisa memilih 'absent'
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
            ->with('success', 'Absensi berhasil disimpan.');
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