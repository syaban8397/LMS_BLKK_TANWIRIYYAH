<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Attendance Session</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} - Meeting {{ $meetingNumber }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Sessions
                </a>
            </div>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="dashboard-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
            <form action="{{ route('instruktur.attendances.update', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Attendance Date --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attendance Date & Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="attendance_date" value="{{ old('attendance_date', $meetingDate ? $meetingDate->format('Y-m-d\TH:i') : '') }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('attendance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline Info (readonly) --}}
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attendance Deadline (cannot be changed)</label>
                    <input type="text" value="{{ $deadline ? $deadline->format('d/m/Y H:i') : 'Not set' }}" readonly
                           class="w-full rounded-lg bg-gray-100 border-gray-200 text-sm px-3 py-2 text-slate-600">
                    <p class="text-xs text-slate-400 mt-1">Students cannot submit/change attendance after this deadline.</p>
                </div>

                {{-- Students Attendance List --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Student Attendance Status</label>
                    <div class="space-y-3 max-h-96 overflow-y-auto border border-slate-200 rounded-xl p-4">
                        @foreach($students as $student)
                            @php
                                $attendanceRecord = $attendances[$student->participant_id] ?? null;
                                $currentStatus = $attendanceRecord ? $attendanceRecord->status : 'absent';
                                $currentNotes = $attendanceRecord ? $attendanceRecord->notes : '';
                            @endphp
                            <div class="flex flex-wrap items-center gap-4 p-3 bg-slate-50 rounded-lg">
                                <div class="w-64">
                                    <p class="font-medium text-slate-800">{{ $student->participant->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $student->participant->email }}</p>
                                </div>
                                <div class="flex-1 min-w-[200px]">
                                    <select name="attendances[{{ $loop->index }}][status]" class="status-select rounded-lg border-slate-300 text-sm px-3 py-2 w-full">
                                        <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }}>✅ Present</option>
                                        <option value="permission" {{ $currentStatus == 'permission' ? 'selected' : '' }}>📝 Permission</option>
                                        <option value="sick" {{ $currentStatus == 'sick' ? 'selected' : '' }}>🤒 Sick</option>
                                        <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                                    </select>
                                    <input type="hidden" name="attendances[{{ $loop->index }}][participant_id]" value="{{ $student->participant_id }}">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="attendances[{{ $loop->index }}][notes]" value="{{ old('attendances.'.$loop->index.'.notes', $currentNotes) }}"
                                           placeholder="Notes (optional)" class="w-full rounded-lg border-slate-300 text-sm px-3 py-2">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('attendances')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('instruktur.attendances.index', [$class, $meetingNumber]) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Update Attendance
                    </button>
                </div>
            </form>
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
        .input-3d {
            transition: all 0.2s ease;
        }
        .input-3d:focus {
            transform: scale(1.01);
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
            border-color: #3b82f6;
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>