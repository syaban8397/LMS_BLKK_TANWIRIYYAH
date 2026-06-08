<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(10);

        $totalPrograms = Program::count();

        $activePrograms = Program::where(
            'status',
            'active'
        )->count();

        $inactivePrograms = Program::where(
            'status',
            'inactive'
        )->count();

        return view(
            'admin.programs.index',
            compact(
                'programs',
                'totalPrograms',
                'activePrograms',
                'inactivePrograms'
            )
        );
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        Program::create($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with(
                'success',
                'Program berhasil ditambahkan.'
            );
    }

    public function show(Program $program)
    {
        return view(
            'admin.programs.show',
            compact('program')
        );
    }

    public function edit(Program $program)
    {
        return view(
            'admin.programs.edit',
            compact('program')
        );
    }

    public function update(
        Request $request,
        Program $program
    ) {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        $program->update($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with(
                'success',
                'Program berhasil diperbarui.'
            );
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with(
                'success',
                'Program berhasil dihapus.'
            );
    }
}