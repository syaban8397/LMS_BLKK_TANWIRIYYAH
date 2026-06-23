<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassParticipant;
use App\Models\Material;
use App\Models\MaterialProgress;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $participations = ClassParticipant::where('participant_id', $user->id)
            ->where('status', 'active')
            ->with('class')
            ->get();

        $primaryClass = $participations
            ->where('status', 'active')
            ->sortByDesc('created_at')
            ->first()?->class;

        $classes = $participations->count();
        $classIds = $participations->pluck('class_id');

        $materials = Material::whereIn('class_id', $classIds)->count();
        $assignments = Assignment::whereIn('class_id', $classIds)->count();
        $certificates = Certificate::where('participant_id', $user->id)->count();
        $completedClasses = $participations->where('status', 'completed')->count();

        $submittedAssignmentIds = Submission::where('participant_id', $user->id)
            ->pluck('assignment_id');
        $pendingAssignments = Assignment::whereIn('class_id', $classIds)
            ->whereNotIn('id', $submittedAssignmentIds)
            ->count();

        $attendanceStats = Attendance::where('participant_id', $user->id)
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(CASE WHEN status IN ('present','permission','sick') THEN 1 ELSE 0 END) as positive")
            ->first();
        $totalAttendances = (int) ($attendanceStats->total ?? 0);
        $presentAttendances = (int) ($attendanceStats->positive ?? 0);
        $attendancePercentage = $totalAttendances > 0
            ? round(($presentAttendances / $totalAttendances) * 100)
            : 0;

        $completedMaterials = MaterialProgress::where('participant_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('material', fn ($q) => $q->whereIn('class_id', $classIds))
            ->count();
        $materialProgressPercentage = $materials > 0
            ? round(($completedMaterials / $materials) * 100)
            : 0;

        $announcements = Announcement::whereIn('class_id', $classIds)
            ->with(['creator', 'class'])
            ->latest()
            ->limit(5)
            ->get();

        $announcementCount = Announcement::whereIn('class_id', $classIds)->count();

        $recentSubmissions = Submission::where('participant_id', $user->id)
            ->with(['assignment.class'])
            ->latest('submitted_at')
            ->limit(5)
            ->get();

        $recentCertificates = Certificate::where('participant_id', $user->id)
            ->with('class')
            ->latest('issued_at')
            ->limit(5)
            ->get();

        return view('dashboard.peserta', compact(
            'classes',
            'materials',
            'assignments',
            'certificates',
            'completedClasses',
            'pendingAssignments',
            'attendancePercentage',
            'materialProgressPercentage',
            'completedMaterials',
            'announcements',
            'announcementCount',
            'primaryClass',
            'recentSubmissions',
            'recentCertificates'
        ));
    }
}
