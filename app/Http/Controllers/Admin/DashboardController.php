<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\ClassModel;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [

            'participants' => User::where('role', 'peserta')->count(),

            'instructors' => User::where('role', 'instruktur')->count(),

            'programs' => Program::count(),

            'classes' => ClassModel::count(),

            'certificates' => Certificate::count(),

            'pendingParticipants' => User::where('role', 'peserta')
                ->where('approval_status', 'pending')
                ->count(),

            'approvedParticipants' => User::where('role', 'peserta')
                ->where('approval_status', 'approved')
                ->count(),

            'rejectedParticipants' => User::where('role', 'peserta')
                ->where('approval_status', 'rejected')
                ->count(),

            // Modul berikutnya (sementara 0 sampai model dibuat)
            'materials' => 0,
            'assignments' => 0,
            'announcements' => 0,
            'attendanceSessions' => 0,
            'attendances' => 0,
            'grades' => 0,
            'portfolios' => 0,
            'notifications' => 0,

        ]);
    }
}