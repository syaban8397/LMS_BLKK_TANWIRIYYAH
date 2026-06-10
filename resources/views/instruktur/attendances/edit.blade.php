<x-app-layout>
    <x-slot name="header"><div><h2 class="text-2xl font-bold text-slate-800">Edit Attendance - Meeting {{ $meetingNumber }}</h2><p class="text-sm text-slate-500 mt-1">{{ $class->title }}</p></div></x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <form action="{{ route('instruktur.attendances.update', [$class, $meetingNumber]) }}" method="POST">
            @csrf @method('PUT')
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50"><div class="max-w-md"><label class="block text-sm font-semibold text-slate-700 mb-2">Attendance Date</label><input type="date" name="attendance_date" value="{{ old('attendance_date', $meetingDate->format('Y-m-d')) }}" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 px-4 py-3"></div></div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-600 text-sm"><tr><th class="px-6 py-4 text-left">Student</th><th class="px-6 py-4 text-left">Status</th><th class="px-6 py-4 text-left">Notes</th></tr></thead>
                        <tbody>
                            @foreach($students as $index => $student)
                            @php $existing = $attendances[$student->participant_id] ?? null; @endphp
                            <tr class="border-t hover:bg-slate-50"><td class="px-6 py-4"><input type="hidden" name="attendances[{{ $index }}][participant_id]" value="{{ $student->participant_id }}"><p class="font-medium text-slate-800">{{ $student->participant->name }}</p><p class="text-xs text-slate-500">{{ $student->participant->email }}</p></td><td class="px-6 py-4"><select name="attendances[{{ $index }}][status]" class="rounded-xl border-slate-200 focus:border-blue-500 px-3 py-2 text-sm"><option value="present" {{ ($existing->status ?? '') == 'present' ? 'selected' : '' }}>✅ Present</option><option value="permission" {{ ($existing->status ?? '') == 'permission' ? 'selected' : '' }}>📝 Permission</option><option value="sick" {{ ($existing->status ?? '') == 'sick' ? 'selected' : '' }}>🤒 Sick</option><option value="absent" {{ ($existing->status ?? '') == 'absent' ? 'selected' : '' }}>❌ Absent</option></select></td><td class="px-6 py-4"><input type="text" name="attendances[{{ $index }}][notes]" value="{{ $existing->notes ?? '' }}" placeholder="Optional notes..." class="w-full rounded-xl border-slate-200 focus:border-blue-500 px-3 py-2 text-sm"></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-slate-200 flex justify-end gap-3"><a href="{{ route('instruktur.attendances.show', [$class, $meetingNumber]) }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 transition">Cancel</a><button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition">Update Attendance</button></div>
            </div>
        </form>
    </div>
</x-app-layout>