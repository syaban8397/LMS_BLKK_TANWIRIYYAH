<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\FinalGrade;
use App\Models\User;
use Illuminate\Support\Collection;

class ReportService
{
    public function __construct(protected CertificateService $certificateService) {}

    public function participantsReport(): Collection
    {
        return User::query()
            ->where('role', 'peserta')
            ->withCount(['classParticipants', 'certificates', 'submissions', 'attendances'])
            ->orderBy('name')
            ->get();
    }

    public function instructorsReport(): Collection
    {
        return User::query()
            ->where('role', 'instruktur')
            ->withCount('classes')
            ->orderBy('name')
            ->get();
    }

    public function classesReport(): Collection
    {
        return ClassModel::query()
            ->with(['program', 'instructor'])
            ->withCount(['participants', 'materials', 'assignments', 'certificates'])
            ->latest()
            ->get();
    }

    public function classParticipantStats(ClassModel $class): array
    {
        return $this->certificateService->getClassStats($class);
    }

    public function buildAttendanceMatrix(ClassModel $class): array
    {
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
                'email' => $student->participant->email,
                'attendances' => [],
                'present_count' => 0,
                'permission_count' => 0,
                'sick_count' => 0,
                'absent_count' => 0,
            ];
        }

        $allAttendances = Attendance::where('class_id', $class->id)->get();

        foreach ($allAttendances as $attendance) {
            if (!isset($attendanceMatrix[$attendance->participant_id])) {
                continue;
            }

            $attendanceMatrix[$attendance->participant_id]['attendances'][$attendance->meeting_number] = $attendance->status;
            $countKey = $attendance->status . '_count';

            if (isset($attendanceMatrix[$attendance->participant_id][$countKey])) {
                $attendanceMatrix[$attendance->participant_id][$countKey]++;
            }
        }

        return compact('students', 'meetings', 'attendanceMatrix');
    }

    public function gradesReport(): Collection
    {
        return FinalGrade::query()
            ->with(['participant', 'class.program', 'class.instructor'])
            ->latest()
            ->get();
    }

    public function certificatesReport(): Collection
    {
        return Certificate::query()
            ->with(['participant', 'class.program', 'class.instructor'])
            ->latest('issued_at')
            ->get();
    }
}
