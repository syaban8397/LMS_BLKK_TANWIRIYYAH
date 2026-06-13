<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipant;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\Submission;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Kelas yang diikuti peserta
        $participations = ClassParticipant::where('participant_id', $user->id)
            ->with('class')
            ->get();
        
        $classes = $participations->count();
        
        // Total materi dari semua kelas yang diikuti
        $classIds = $participations->pluck('class_id');
        $materials = Material::whereIn('class_id', $classIds)->count();
        
        // Total tugas dari semua kelas yang diikuti
        $assignments = Assignment::whereIn('class_id', $classIds)->count();
        
        // Sertifikat (sesuaikan dengan model Anda, jika ada)
        $certificates = Certificate::where('participant_id', $user->id)->count();
        
        // Kelas selesai (status completed)
        $completedClasses = $participations->where('status', 'completed')->count();
        
        // Tugas belum dikumpulkan / pending
        $submittedAssignmentIds = Submission::where('participant_id', $user->id)
            ->pluck('assignment_id')
            ->toArray();
        $pendingAssignments = Assignment::whereIn('class_id', $classIds)
            ->whereNotIn('id', $submittedAssignmentIds)
            ->count();
        
        // Persentase kehadiran (contoh sederhana, hitung dari semua pertemuan)
        $totalAttendances = Attendance::where('participant_id', $user->id)->count();
        $presentAttendances = Attendance::where('participant_id', $user->id)
            ->whereIn('status', ['present', 'permission', 'sick'])
            ->count();
        $attendancePercentage = $totalAttendances > 0 
            ? round(($presentAttendances / $totalAttendances) * 100) 
            : 0;
        
        return view('dashboard.peserta', compact(
            'classes',
            'materials',
            'assignments',
            'certificates',
            'completedClasses',
            'pendingAssignments',
            'attendancePercentage'
        ));
    }
}