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
            ->with('class')
            ->get();

        $primaryClass = ClassParticipant::where('participant_id', $user->id)
            ->where('status', 'active')
            ->with('class')
            ->latest()
            ->first()?->class;

        $classes = $participations->count();
        $classIds = $participations->pluck('class_id');

        $materials = Material::whereIn('class_id', $classIds)->count();
        $assignments = Assignment::whereIn('class_id', $classIds)->count();
        $certificates = Certificate::where('participant_id', $user->id)->count();
        $completedClasses = $participations->where('status', 'completed')->count();

        $submittedAssignmentIds = Submission::where('participant_id', $user->id)
            ->pluck('assignment_id')
            ->toArray();
        $pendingAssignments = Assignment::whereIn('class_id', $classIds)
            ->whereNotIn('id', $submittedAssignmentIds)
            ->count();

        $totalAttendances = Attendance::where('participant_id', $user->id)->count();
        $presentAttendances = Attendance::where('participant_id', $user->id)
            ->whereIn('status', ['present', 'permission', 'sick'])
            ->count();
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
            'primaryClass'
        ));
    }
}
