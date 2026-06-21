<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\FinalGrade;
use App\Models\Material;
use App\Models\Program;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $positiveAttendance = Attendance::whereIn('status', ['present', 'permission', 'sick'])->count();
        $totalAttendance = Attendance::count();
        $avgAttendance = $totalAttendance > 0
            ? round(($positiveAttendance / $totalAttendance) * 100, 1)
            : 0;

        $participantCountsByProgram = ClassParticipant::query()
            ->join('classes', 'classes.id', '=', 'class_participants.class_id')
            ->selectRaw('classes.program_id, COUNT(*) as aggregate')
            ->groupBy('classes.program_id')
            ->pluck('aggregate', 'program_id');

        $programDistribution = Program::query()
            ->orderBy('name')
            ->get()
            ->map(fn (Program $program) => [
                'name' => $program->name,
                'count' => (int) ($participantCountsByProgram[$program->id] ?? 0),
            ])
            ->filter(fn ($row) => $row['count'] > 0)
            ->values();

        $maxProgramCount = $programDistribution->max('count') ?: 1;

        $userStats = User::query()
            ->selectRaw("SUM(CASE WHEN role = 'peserta' THEN 1 ELSE 0 END) as participants")
            ->selectRaw("SUM(CASE WHEN role = 'instruktur' AND is_active = 1 THEN 1 ELSE 0 END) as instructors")
            ->selectRaw("SUM(CASE WHEN role = 'peserta' AND approval_status = 'pending' THEN 1 ELSE 0 END) as pending_participants")
            ->first();

        $entityCounts = [
            'programs' => Program::count(),
            'classes' => ClassModel::where('status', 'active')->count(),
            'certificates' => Certificate::count(),
            'materials' => Material::count(),
            'assignments' => Assignment::count(),
            'announcements' => Announcement::count(),
            'grades' => FinalGrade::count(),
        ];

        return view('dashboard.admin', [
            'participants' => (int) ($userStats->participants ?? 0),
            'instructors' => (int) ($userStats->instructors ?? 0),
            'programs' => $entityCounts['programs'],
            'classes' => $entityCounts['classes'],
            'certificates' => $entityCounts['certificates'],
            'pendingParticipants' => (int) ($userStats->pending_participants ?? 0),
            'materials' => $entityCounts['materials'],
            'assignments' => $entityCounts['assignments'],
            'announcements' => $entityCounts['announcements'],
            'attendanceSessions' => Attendance::query()
                ->select('class_id', 'meeting_number')
                ->distinct()
                ->count(),
            'attendances' => $totalAttendance,
            'grades' => $entityCounts['grades'],
            'avgAttendance' => $avgAttendance,
            'programDistribution' => $programDistribution,
            'maxProgramCount' => $maxProgramCount,
        ]);
    }
}
