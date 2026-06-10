<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::with(['program', 'instructor'])
            ->latest()
            ->paginate(10);

        $totalClasses = ClassModel::count();

        $activeClasses = ClassModel::where('status', 'active')->count();

        $draftClasses = ClassModel::where('status', 'draft')->count();

        return view(
            'admin.classes.index',
            compact(
                'classes',
                'totalClasses',
                'activeClasses',
                'draftClasses'
            )
        );
    }

    public function create()
    {
        $programs = Program::all();

        $instructors = User::where('role', 'instruktur')
            ->where('is_active', true)
            ->get();

        return view(
            'admin.classes.create',
            compact('programs', 'instructors')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'instructor_id' => 'required|exists:users,id',
            'code' => 'required|unique:classes,code|max:50',
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        ClassModel::create($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(ClassModel $class)
    {
        $class->load(['program', 'instructor', 'participants.participant']);

        return view(
            'admin.classes.show',
            compact('class')
        );
    }

    public function edit(ClassModel $class)
    {
        $class->load(['program', 'instructor']);

        $programs = Program::all();

        $instructors = User::where('role', 'instruktur')
            ->where('is_active', true)
            ->get();

        return view(
            'admin.classes.edit',
            compact('class', 'programs', 'instructors')
        );
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'instructor_id' => 'required|exists:users,id',
            'code' => 'required|unique:classes,code,' . $class->id . '|max:50',
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        $class->update($validated);

        return redirect()
            ->route('admin.classes.show', $class)
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
