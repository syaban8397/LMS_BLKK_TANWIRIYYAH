<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;

class DashboardController extends Controller
{
    public function index()
    {
        $instructorId = auth()->id();
        $totalClasses = ClassModel::where('instructor_id', $instructorId)->count();
        $activeClasses = ClassModel::where('instructor_id', $instructorId)->where('status', 'active')->count();
        $totalStudents = ClassParticipant::whereIn('class_id', ClassModel::where('instructor_id', $instructorId)->pluck('id'))->count();
        $recentClasses = ClassModel::where('instructor_id', $instructorId)->latest()->limit(5)->get();

        return view('dashboard.instruktur', compact('totalClasses', 'activeClasses', 'totalStudents', 'recentClasses'));
    }
}