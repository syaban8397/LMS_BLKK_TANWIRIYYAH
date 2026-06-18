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
        $totalAttendance = Attendance::count();
        $positiveAttendance = Attendance::whereIn('status', ['present', 'permission', 'sick'])->count();
        $avgAttendance = $totalAttendance > 0
            ? round(($positiveAttendance / $totalAttendance) * 100, 1)
            : 0;

        $programDistribution = Program::query()
            ->orderBy('name')
            ->get()
            ->map(function (Program $program) {
                $count = ClassParticipant::query()
                    ->whereHas('class', fn ($q) => $q->where('program_id', $program->id))
                    ->count();

                return [
                    'name' => $program->name,
                    'count' => $count,
                ];
            })
            ->filter(fn ($row) => $row['count'] > 0)
            ->values();

        $maxProgramCount = $programDistribution->max('count') ?: 1;

        return view('dashboard.admin', [
            'participants' => User::where('role', 'peserta')->count(),
            'instructors' => User::where('role', 'instruktur')->where('is_active', true)->count(),
            'programs' => Program::count(),
            'classes' => ClassModel::where('status', 'active')->count(),
            'certificates' => Certificate::count(),
            'pendingParticipants' => User::where('role', 'peserta')
                ->where('approval_status', 'pending')
                ->count(),
            'materials' => Material::count(),
            'assignments' => Assignment::count(),
            'announcements' => Announcement::count(),
            'attendanceSessions' => Attendance::query()
                ->select('class_id', 'meeting_number')
                ->distinct()
                ->count(),
            'attendances' => $totalAttendance,
            'grades' => FinalGrade::count(),
            'avgAttendance' => $avgAttendance,
            'programDistribution' => $programDistribution,
            'maxProgramCount' => $maxProgramCount,
        ]);
    }
}
