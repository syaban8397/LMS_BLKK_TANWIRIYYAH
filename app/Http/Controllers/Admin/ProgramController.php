<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount('classes')->latest()->paginate(10);

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
            'certificate_degree' => 'nullable|in:' . implode(',', Program::certificateDegreeCodes()),
            'validity_years' => 'nullable|integer|min:1|max:10',
            'capacity' => 'required|integer|min:1|max:999',
        ]);

        $validated['validity_years'] = $validated['validity_years'] ?? config('certificate.default_validity_years');

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
            'certificate_degree' => 'nullable|in:' . implode(',', Program::certificateDegreeCodes()),
            'validity_years' => 'nullable|integer|min:1|max:10',
            'capacity' => 'required|integer|min:1|max:999',
        ]);

        $validated['validity_years'] = $validated['validity_years'] ?? config('certificate.default_validity_years');

        if ($validated['capacity'] < $program->classCount()) {
            return back()
                ->withInput()
                ->withErrors([
                    'capacity' => 'Kapasitas tidak boleh kurang dari jumlah kelas yang sudah ada (' . $program->classCount() . ').',
                ]);
        }

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