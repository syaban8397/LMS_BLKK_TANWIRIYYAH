<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div><p class="text-sm text-slate-500 mt-1">Select students to enroll in this class.</p></div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        {{-- ENROLLED STUDENTS --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h3 class="font-bold text-slate-800">Enrolled Students ({{ $participants->total() }})</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-center">Enrolled At</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                        <tr class="border-t hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-800 font-medium">{{ $participant->participant->name }}</td>
                            <td class="px-6 py-4 text-slate-600 text-sm">{{ $participant->participant->email }}</td>
                            <td class="px-6 py-4 text-center text-slate-700 text-sm">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('instruktur.classes.update-student-status', [$class, $participant]) }}" method="POST" class="inline-block">
                                    @csrf @method('PATCH')
                                    <select name="status" class="px-2 py-1 rounded text-xs border border-slate-300 focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                        <option value="active" {{ $participant->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ $participant->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="dropped" {{ $participant->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('instruktur.classes.remove-student', [$class, $participant]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm transition">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No students enrolled yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $participants->links() }}</div>
        </div>

        {{-- ADD STUDENTS FORM --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
            @if($availableStudents->count() == 0)
                <div class="text-center py-12">
                    <p class="text-slate-500 text-lg">No available students to add. All active students are already enrolled or there are no active students in the system.</p>
                    <a href="{{ route('instruktur.classes.show', $class) }}" class="mt-6 inline-block px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl transition">Back to Class</a>
                </div>
            @else
                <form action="{{ route('instruktur.classes.add-student', $class) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-4">Select Students (Current: {{ $class->participants->count() }}/{{ $class->quota }})</label>
                        @if($availableStudents->count() > 0)
                            <div class="bg-slate-50 rounded-2xl p-4 space-y-3 max-h-96 overflow-y-auto">
                                @foreach($availableStudents as $student)
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white transition cursor-pointer">
                                    <input type="checkbox" name="participant_ids[]" value="{{ $student->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">{{ $student->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $student->email }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                        @error('participant_ids')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('instruktur.classes.stream', $class) }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Cancel</a>
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">Add Selected Students</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>