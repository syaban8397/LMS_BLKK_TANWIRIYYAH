<?php
// app/Http/Controllers/Instruktur/AttendanceController.php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\ClassParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Daftar sesi absensi (per meeting)
    public function index(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $meetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number', 'attendance_date')
            ->distinct()
            ->orderBy('meeting_number', 'desc')
            ->get();
        
        return view('instruktur.attendances.index', compact('class', 'meetings'));
    }
    
    // Form buat sesi absensi baru
    public function create(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $existingMeetings = Attendance::where('class_id', $class->id)
            ->distinct()
            ->pluck('meeting_number')
            ->toArray();
        
        $nextMeeting = !empty($existingMeetings) ? max($existingMeetings) + 1 : 1;
        
        return view('instruktur.attendances.create', compact('class', 'nextMeeting'));
    }
    
    // Menyimpan sesi absensi baru (membuat record kosong untuk semua siswa)
    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $validated = $request->validate([
            'meeting_number' => 'required|integer|min:1',
            'attendance_date' => 'required|date',
        ]);
        
        // Cek apakah sesi sudah ada
        $exists = Attendance::where('class_id', $class->id)
            ->where('meeting_number', $validated['meeting_number'])
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Meeting ' . $validated['meeting_number'] . ' already exists.');
        }
        
        $students = ClassParticipant::where('class_id', $class->id)
            ->where('status', 'active')
            ->get();
        
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No active students in this class.');
        }
        
        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                Attendance::create([
                    'class_id' => $class->id,
                    'participant_id' => $student->participant_id,
                    'meeting_number' => $validated['meeting_number'],
                    'attendance_date' => $validated['attendance_date'],
                    'status' => 'absent',
                    'submission_type' => 'self',
                    'created_by' => auth()->id(),
                ]);
            }
            
            DB::commit();
            return redirect()->route('instruktur.attendances.show', [$class, $validated['meeting_number']])
                ->with('success', 'Attendance session for Meeting ' . $validated['meeting_number'] . ' created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create attendance session.');
        }
    }
    
    // Lihat detail absensi per meeting
    public function show(ClassModel $class, $meetingNumber)
    {
        $this->authorizeInstructor($class);
        
        $attendances = Attendance::where('class_id', $class->id)
            ->where('meeting_number', $meetingNumber)
            ->with('participant')
            ->get();
        
        if ($attendances->isEmpty()) {
            return redirect()->route('instruktur.attendances.index', $class)
                ->with('error', 'Attendance session not found.');
        }
        
        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'permission' => $attendances->where('status', 'permission')->count(),
            'sick' => $attendances->where('status', 'sick')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'total' => $attendances->count(),
        ];
        
        $meetingDate = $attendances->first()->attendance_date;
        
        return view('instruktur.attendances.show', compact('class', 'attendances', 'meetingNumber', 'meetingDate', 'summary'));
    }
    
    // Form edit absensi per meeting (instruktur mengganti status siswa)
    public function edit(ClassModel $class, $meetingNumber)
    {
        $this->authorizeInstructor($class);
        
        $attendances = Attendance::where('class_id', $class->id)
            ->where('meeting_number', $meetingNumber)
            ->with('participant')
            ->get()
            ->keyBy('participant_id');
        
        if ($attendances->isEmpty()) {
            return redirect()->route('instruktur.attendances.index', $class)
                ->with('error', 'Attendance session not found.');
        }
        
        $students = ClassParticipant::where('class_id', $class->id)
            ->where('status', 'active')
            ->with('participant')
            ->get();
        
        $meetingDate = $attendances->first()->attendance_date;
        
        return view('instruktur.attendances.edit', compact('class', 'students', 'attendances', 'meetingNumber', 'meetingDate'));
    }
    
    // Update absensi (instruktur mengganti)
    public function update(Request $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeInstructor($class);
        
        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.participant_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:present,permission,sick,absent',
            'attendances.*.notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            foreach ($validated['attendances'] as $attendanceData) {
                $attendance = Attendance::where('class_id', $class->id)
                    ->where('participant_id', $attendanceData['participant_id'])
                    ->where('meeting_number', $meetingNumber)
                    ->first();
                
                if ($attendance) {
                    $attendance->update([
                        'status' => $attendanceData['status'],
                        'notes' => $attendanceData['notes'] ?? null,
                        'attendance_date' => $validated['attendance_date'],
                        'submission_type' => 'instructor',
                        'updated_by' => auth()->id(),
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('instruktur.attendances.show', [$class, $meetingNumber])
                ->with('success', 'Attendance updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update attendance.');
        }
    }
    
    // Hapus sesi absensi
    public function destroy(ClassModel $class, $meetingNumber)
    {
        $this->authorizeInstructor($class);
        
        Attendance::where('class_id', $class->id)
            ->where('meeting_number', $meetingNumber)
            ->delete();
        
        return redirect()->route('instruktur.attendances.index', $class)
            ->with('success', 'Attendance session deleted successfully.');
    }
    
    // Laporan rekap absensi
    public function report(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $students = ClassParticipant::where('class_id', $class->id)
            ->where('status', 'active')
            ->with('participant')
            ->get();
        
        $meetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number', 'attendance_date')
            ->distinct()
            ->orderBy('meeting_number')
            ->get();
        
        $attendanceMatrix = [];
        foreach ($students as $student) {
            $attendanceMatrix[$student->participant_id] = [
                'name' => $student->participant->name,
                'attendances' => [],
                'present_count' => 0,
                'permission_count' => 0,
                'sick_count' => 0,
                'absent_count' => 0,
            ];
        }
        
        $allAttendances = Attendance::where('class_id', $class->id)
            ->with('participant')
            ->get();
        
        foreach ($allAttendances as $attendance) {
            if (isset($attendanceMatrix[$attendance->participant_id])) {
                $attendanceMatrix[$attendance->participant_id]['attendances'][$attendance->meeting_number] = $attendance->status;
                $attendanceMatrix[$attendance->participant_id][$attendance->status . '_count']++;
            }
        }
        
        return view('instruktur.attendances.report', compact('class', 'students', 'meetings', 'attendanceMatrix'));
    }
    
    protected function authorizeInstructor(ClassModel $class)
    {
        if ($class->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}