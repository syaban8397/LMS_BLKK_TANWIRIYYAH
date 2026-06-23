<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\Material;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $instructorId = auth()->id();
        $classIds = ClassModel::where('instructor_id', $instructorId)->pluck('id');

        $totalClasses = $classIds->count();
        $activeClasses = ClassModel::where('instructor_id', $instructorId)->where('status', 'active')->count();
        $totalStudents = ClassParticipant::whereIn('class_id', $classIds)->count();
        $recentClasses = ClassModel::where('instructor_id', $instructorId)
            ->withCount('participants')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.instruktur', [
            'classes' => $totalClasses,
            'activeClasses' => $activeClasses,
            'participants' => $totalStudents,
            'materials' => Material::whereIn('class_id', $classIds)->count(),
            'assignments' => Assignment::whereIn('class_id', $classIds)->count(),
            'announcements' => Announcement::whereIn('class_id', $classIds)->count(),
            'attendanceSessions' => Attendance::whereIn('class_id', $classIds)
                ->select('class_id', 'meeting_number')
                ->distinct()
                ->count(),
            'pendingGrades' => Submission::query()
                ->where('submissions.status', 'submitted')
                ->whereIn(
                    'submissions.assignment_id',
                    Assignment::query()->select('id')->whereIn('class_id', $classIds)
                )
                ->count(),
            'recentClasses' => $recentClasses,
            'pendingSubmissionList' => Submission::query()
                ->where('submissions.status', 'submitted')
                ->whereIn(
                    'submissions.assignment_id',
                    Assignment::query()->select('id')->whereIn('class_id', $classIds)
                )
                ->with(['participant', 'assignment.class'])
                ->latest('submitted_at')
                ->limit(5)
                ->get(),
            'recentSubmissions' => Submission::query()
                ->whereIn(
                    'submissions.assignment_id',
                    Assignment::query()->select('id')->whereIn('class_id', $classIds)
                )
                ->with(['participant', 'assignment'])
                ->latest('submitted_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
