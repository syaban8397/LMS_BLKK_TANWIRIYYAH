<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [

            'participants' => User::where('role', 'peserta')->count(),

            'instructors' => User::where('role', 'instruktur')->count(),

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

        ]);
    }
}