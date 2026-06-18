<x-app-layout>
<div class="create-attendance-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.attendance.create_session')"
            :subtitle="$class->title"
            :back-url="route('instruktur.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_sessions')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions'), 'url' => route('instruktur.attendances.index', $class)],
                ['label' => __('lms.attendance.create_session')],
            ]"
        />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card>
            <form action="{{ route('instruktur.attendances.store', $class) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Meeting Number --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.meeting_number') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="meeting_number" value="{{ old('meeting_number', $nextMeeting) }}" min="1" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('meeting_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">{{ __('lms.attendance.next_meeting_hint') }} <span class="font-semibold text-blue-600">{{ $nextMeeting }}</span></p>
                </div>

                {{-- Attendance Date & Time (dengan jam) --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.class_start') }} <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="attendance_date" 
                           value="{{ old('attendance_date', now()->format('Y-m-d\TH:i')) }}" 
                           required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('attendance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline Minutes --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.attendance.deadline_minutes') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="deadline_minutes" value="{{ old('deadline_minutes', 60) }}" min="0" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('deadline_minutes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">
                        {{ __('lms.attendance.deadline_submit_hint', ['minutes' => old('deadline_minutes', 60)]) }}
                    </p>
                </div>

                {{-- Info Note --}}
                <div class="info-box bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-semibold text-blue-800 text-sm">{{ __('lms.assignment.info_title') }}</p>
                            <p class="text-xs text-blue-600 mt-0.5">
                                {{ __('lms.attendance.info_after_deadline') }}
                            </p>
                        </div>
                    </div>
                </div>

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('instruktur.attendances.index', $class)">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.attendance.create_btn') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
