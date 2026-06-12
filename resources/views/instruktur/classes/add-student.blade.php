<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manage Students</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} • Enroll or manage participants</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Enrolled Students Table --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-800">Enrolled Students</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Total: {{ $participants->total() }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Photo</th>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Phone</th>
                            <th class="px-6 py-4 text-center">Enrolled At</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                            @php $student = $participant->participant; @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    @if($student->photo)
                                        <img src="{{ Storage::url($student->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-800 font-medium">{{ $student->name }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">{{ $student->email }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">{{ $student->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-slate-700 text-sm">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('instruktur.classes.update-student-status', [$class, $participant]) }}" method="POST" class="inline-block">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-xs rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 px-2 py-1 bg-white">
                                            <option value="active" {{ $participant->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ $participant->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="dropped" {{ $participant->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('instruktur.classes.remove-student', [$class, $participant]) }}" method="POST" onsubmit="return confirm('Remove this student from class?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-3d px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition shadow-sm">Remove</button>
                                    </form>
                                </td>
                            <tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">No students enrolled yet. Add students using the form below.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($participants->hasPages())
                <div class="px-6 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $participants->links() }}
                </div>
            @endif
        </div>

        {{-- Add Students Form --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Add New Students</h3>
                <p class="text-xs text-slate-500 mt-0.5">Current enrollment: {{ $class->participants->count() }} / {{ $class->quota }}</p>
            </div>

            <div class="p-6">
                @if($availableStudents->count() == 0)
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2">👥</div>
                        <p class="text-slate-500">No available students to add. All active students are already enrolled or there are no active students in the system.</p>
                        <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d inline-block mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Back to Class</a>
                    </div>
                @else
                    <form action="{{ route('instruktur.classes.add-student', $class) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Select students to enroll</label>
                            <div class="bg-slate-50 rounded-xl p-4 space-y-2 max-h-96 overflow-y-auto border border-slate-200">
                                @foreach($availableStudents as $student)
                                    <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white transition cursor-pointer">
                                        <input type="checkbox" name="participant_ids[]" value="{{ $student->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                        <div class="flex items-center gap-3 flex-1">
                                            @if($student->photo)
                                                <img src="{{ Storage::url($student->photo) }}" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-xs">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">{{ $student->name }}</p>
                                                <p class="text-sm text-slate-500">{{ $student->email }}</p>
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                {{ $student->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('participant_ids')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                            <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Cancel</a>
                            <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">Add Selected Students</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>