<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\ClassParticipant;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    use AuthorizesInstructorClass;

    public function __construct(protected ReportService $reportService) {}

    // Daftar sesi absensi (per meeting)
    public function index(ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $meetings = Attendance::where('class_id', $class->id)
            ->select('meeting_number', 'attendance_date', 'attendance_deadline')
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
    
    // Menyimpan sesi absensi baru dengan deadline (fix TypeError)
    public function store(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);
        
        $validated = $request->validate([
            'meeting_number'   => 'required|integer|min:1',
            'attendance_date'  => 'required|date',
            'deadline_minutes' => 'required|integer|min:0',
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
        
        $attendanceDate = \Carbon\Carbon::parse($validated['attendance_date']);
        // Cast ke int untuk menghindari TypeError
        $deadline = $attendanceDate->copy()->addMinutes((int) $validated['deadline_minutes']);
        
        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                Attendance::create([
                    'class_id'            => $class->id,
                    'participant_id'      => $student->participant_id,
                    'meeting_number'      => $validated['meeting_number'],
                    'attendance_date'     => $attendanceDate,
                    'attendance_deadline' => $deadline,
                    'status'              => 'absent',
                    'submission_type'     => 'self',
                    'created_by'          => auth()->id(),
                ]);
            }
            
            DB::commit();
            return redirect()->route('instruktur.attendances.show', [$class, $validated['meeting_number']])
                ->with('success', 'Attendance session for Meeting ' . $validated['meeting_number'] . ' created successfully. Deadline: ' . $deadline);
                
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
            'present'    => $attendances->where('status', 'present')->count(),
            'permission' => $attendances->where('status', 'permission')->count(),
            'sick'       => $attendances->where('status', 'sick')->count(),
            'absent'     => $attendances->where('status', 'absent')->count(),
            'total'      => $attendances->count(),
        ];
        
        $meetingDate = $attendances->first()->attendance_date;
        $deadline    = $attendances->first()->attendance_deadline;
        
        return view('instruktur.attendances.show', compact('class', 'attendances', 'meetingNumber', 'meetingDate', 'deadline', 'summary'));
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
        $deadline    = $attendances->first()->attendance_deadline;
        
        return view('instruktur.attendances.edit', compact('class', 'students', 'attendances', 'meetingNumber', 'meetingDate', 'deadline'));
    }
    
    // Update absensi (instruktur mengganti) - optional deadline restriction commented
    public function update(Request $request, ClassModel $class, $meetingNumber)
    {
        $this->authorizeInstructor($class);
        
        // Jika ingin instruktur TIDAK BISA mengubah setelah deadline, aktifkan kode di bawah:
        /*
        $first = Attendance::where('class_id', $class->id)->where('meeting_number', $meetingNumber)->first();
        if ($first && now()->gt($first->attendance_deadline)) {
            return redirect()->back()->with('error', 'Sesi absensi sudah ditutup. Tidak dapat mengubah status.');
        }
        */
        
        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'extend_deadline_minutes' => 'nullable|integer|min:0|max:1440',
            'attendances' => 'required|array',
            'attendances.*.participant_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:present,permission,sick,absent',
            'attendances.*.notes' => 'nullable|string',
        ]);
        
        $first = Attendance::where('class_id', $class->id)
            ->where('meeting_number', $meetingNumber)
            ->first();

        $newStart = \Carbon\Carbon::parse($validated['attendance_date']);
        $extendMinutes = (int) ($validated['extend_deadline_minutes'] ?? 0);
        $newDeadline = $first && $first->attendance_deadline
            ? $first->attendance_deadline->copy()->addMinutes($extendMinutes)
            : $newStart->copy()->addMinutes(60);

        if ($newStart->gt($newDeadline)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jam mulai tidak boleh setelah batas waktu absensi. Perpanjang deadline terlebih dahulu.');
        }
        
        DB::beginTransaction();
        try {
            foreach ($validated['attendances'] as $attendanceData) {
                $attendance = Attendance::where('class_id', $class->id)
                    ->where('participant_id', $attendanceData['participant_id'])
                    ->where('meeting_number', $meetingNumber)
                    ->first();
                
                if ($attendance) {
                    $attendance->update([
                        'status'          => $attendanceData['status'],
                        'notes'           => $attendanceData['notes'] ?? null,
                        'attendance_date' => $newStart,
                        'attendance_deadline' => $newDeadline,
                        'submission_type' => 'instructor',
                        'updated_by'      => auth()->id(),
                    ]);
                }
            }
            
            DB::commit();
            $message = 'Attendance updated successfully.';
            if ($extendMinutes > 0) {
                $message .= ' Deadline diperpanjang ' . $extendMinutes . ' menit (baru: ' . $newDeadline->format('d/m/Y H:i') . ').';
            }
            return redirect()->route('instruktur.attendances.show', [$class, $meetingNumber])
                ->with('success', $message);
                
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

        $report = $this->reportService->buildAttendanceMatrix($class);

        return view('instruktur.attendances.report', array_merge(compact('class'), $report));
    }
}