<x-app-layout>
<div class="edit-attendance-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.attendance.edit_session')"
            :subtitle="__('lms.attendance.edit_subtitle', ['title' => $class->title, 'number' => $meetingNumber])"
            :back-url="route('instruktur.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_sessions')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions'), 'url' => route('instruktur.attendances.index', $class)],
                ['label' => __('lms.attendance.edit_session')],
            ]"
        />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card>
            <form action="{{ route('instruktur.attendances.update', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Attendance Date --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.attendance_date_label') }} <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="attendance_date" value="{{ old('attendance_date', $meetingDate ? $meetingDate->format('Y-m-d\TH:i') : '') }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('attendance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline Info & Extension --}}
                <div class="form-group">
                    <div class="deadline-box bg-gray-50 rounded-lg p-4 border border-gray-200 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.current_deadline') }}</label>
                            <input type="text" value="{{ $deadline ? $deadline->format('d/m/Y H:i') : __('lms.attendance.not_set') }}" readonly
                                   class="w-full rounded-lg bg-gray-100 border-gray-200 text-sm px-3 py-2 text-slate-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.extend_deadline') }}</label>
                            <input type="number" name="extend_deadline_minutes" value="{{ old('extend_deadline_minutes', 0) }}" min="0" max="1440"
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2"
                                   placeholder="{{ __('lms.attendance.extend_no_change') }}">
                            <p class="text-xs text-slate-400 mt-1">{{ __('lms.attendance.extend_hint') }}</p>
                            @error('extend_deadline_minutes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Students Attendance List --}}
                <div class="form-group">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">{{ __('lms.attendance.student_status') }}</label>
                </div>
                <div class="student-list-container">
                    <div class="space-y-3 max-h-96 overflow-y-auto border border-slate-200 rounded-xl p-4 bg-slate-50/30">
                        @foreach($students as $student)
                            @php
                                $attendanceRecord = $attendances[$student->participant_id] ?? null;
                                $currentStatus = $attendanceRecord ? $attendanceRecord->status : 'absent';
                                $currentNotes = $attendanceRecord ? $attendanceRecord->notes : '';
                            @endphp
                            <div class="student-row flex flex-wrap items-center gap-4 p-3 bg-white rounded-lg border border-slate-100">
                                <div class="w-64">
                                    <p class="font-medium text-slate-800">{{ $student->participant->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $student->participant->email }}</p>
                                </div>
                                <div class="flex-1 min-w-[200px]">
                                    <select name="attendances[{{ $loop->index }}][status]" class="status-select rounded-lg border-slate-300 text-sm px-3 py-2 w-full focus:ring-blue-400">
                                        <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }}>✅ {{ __('lms.report.present') }}</option>
                                        <option value="permission" {{ $currentStatus == 'permission' ? 'selected' : '' }}>📝 {{ __('lms.report.permission') }}</option>
                                        <option value="sick" {{ $currentStatus == 'sick' ? 'selected' : '' }}>🤒 {{ __('lms.report.sick') }}</option>
                                        <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }}>❌ {{ __('lms.report.absent') }}</option>
                                    </select>
                                    <input type="hidden" name="attendances[{{ $loop->index }}][participant_id]" value="{{ $student->participant_id }}">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="attendances[{{ $loop->index }}][notes]" value="{{ old('attendances.'.$loop->index.'.notes', $currentNotes) }}"
                                           placeholder="{{ __('lms.attendance.notes_optional') }}" class="w-full rounded-lg border-slate-300 text-sm px-3 py-2 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('attendances')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('instruktur.attendances.index', [$class, $meetingNumber])">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.attendance.update_btn') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
