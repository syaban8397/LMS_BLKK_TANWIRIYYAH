{{-- resources/views/peserta/attendances/show.blade.php --}}
<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.attendance.meeting_title_peserta', ['number' => $meetingNumber])"
            :subtitle="$class->title . ' • ' . \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y H:i')"
            :back-url="route('peserta.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_attendance')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.common.attendance'), 'url' => route('peserta.attendances.index', $class)],
                ['label' => __('lms.attendance.meeting_title_peserta', ['number' => $meetingNumber])],
            ]"
        />

        @php
            $isNotStarted = now()->lt($attendance->attendance_date);
            $statusLabels = [
                'present' => __('lms.report.present'),
                'permission' => __('lms.report.permission'),
                'sick' => __('lms.report.sick'),
                'absent' => __('lms.report.absent'),
            ];
            $statusIcons = [
                'present' => 'check-circle',
                'permission' => 'edit',
                'sick' => 'warning',
                'absent' => 'ban',
            ];
            $statusBadgeClasses = [
                'present' => 'lms-badge--success',
                'permission' => 'lms-badge--warning',
                'sick' => 'lms-badge--warning',
                'absent' => 'lms-badge--danger',
            ];
        @endphp

        @if($attendance->submission_type == 'instructor')
            <x-lms-section :title="__('lms.attendance.locked_title')" icon="ban" compact>
                <x-lms-panel>
                    <div class="text-center py-4">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-700 mb-3">
                            <x-lms-icon name="ban" class="w-6 h-6" />
                        </span>
                        <h4 class="text-lg font-bold text-amber-800 mb-2">{{ __('lms.attendance.locked_title') }}</h4>
                        <p class="text-amber-700 mb-4">{{ __('lms.attendance.locked_desc') }}</p>
                        <x-lms-notice tone="warning">
                            <p>{{ __('lms.attendance.current_status') }}
                                <span class="lms-badge {{ $statusBadgeClasses[$attendance->status] }} inline-flex items-center gap-1 ml-1">
                                    <x-lms-icon :name="$statusIcons[$attendance->status]" class="w-3 h-3" />
                                    {{ $statusLabels[$attendance->status] }}
                                </span>
                            </p>
                            @if($attendance->notes)
                                <p class="text-sm mt-2">{{ __('lms.assignment.notes_label') }} {{ $attendance->notes }}</p>
                            @endif
                        </x-lms-notice>
                    </div>
                </x-lms-panel>
            </x-lms-section>
        @elseif($isNotStarted)
            <x-lms-section :title="__('lms.attendance.session_not_started_title')" icon="clock" compact>
                <x-lms-panel>
                    <div class="text-center py-4">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-700 mb-3">
                            <x-lms-icon name="clock" class="w-6 h-6" />
                        </span>
                        <h4 class="text-lg font-bold text-blue-800 mb-2">{{ __('lms.attendance.not_time_yet') }}</h4>
                        <x-lms-notice tone="info">
                            <p>{{ __('lms.attendance.session_opens_at', ['datetime' => $attendance->attendance_date->format('d M Y H:i')]) }}</p>
                            <p class="text-sm mt-1">{{ __('lms.attendance.come_back_later') }}</p>
                        </x-lms-notice>
                    </div>
                </x-lms-panel>
            </x-lms-section>

        @elseif($isExpired)
            <x-lms-section :title="__('lms.attendance.deadline_passed_title')" icon="clock" compact>
                <x-lms-panel>
                    <div class="text-center py-4">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-700 mb-3">
                            <x-lms-icon name="clock" class="w-6 h-6" />
                        </span>
                        <h4 class="text-lg font-bold text-red-800 mb-2">{{ __('lms.attendance.submission_deadline_passed') }}</h4>
                        <x-lms-notice tone="danger">
                            <p>{{ __('lms.attendance.cannot_submit_contact') }}</p>
                            @if($attendance->attendance_deadline)
                                <p class="text-sm mt-2">{{ __('lms.assignment.deadline_was', ['date' => $attendance->attendance_deadline->format('d M Y H:i')]) }}</p>
                            @endif
                        </x-lms-notice>
                    </div>
                </x-lms-panel>
            </x-lms-section>

        @else
            <x-lms-section :title="__('lms.attendance.attendance_form')" icon="clipboard" compact>
                <x-lms-panel :meta="__('lms.attendance.select_status_hint')">
                    <form action="{{ route('peserta.attendances.submit', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">{{ __('lms.attendance.choose_status') }}</label>
                            <div class="grid md:grid-cols-3 gap-4">
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="status" value="present" {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }} class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                    <div>
                                        <x-lms-icon name="check-circle" class="w-6 h-6 text-green-600 mb-1" />
                                        <p class="font-semibold text-green-700">{{ __('lms.report.present') }}</p>
                                        <p class="text-xs text-slate-500">{{ __('lms.attendance.present_desc') }}</p>
                                    </div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-yellow-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                                    <input type="radio" name="status" value="permission" {{ old('status', $attendance->status) == 'permission' ? 'checked' : '' }} class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                                    <div>
                                        <x-lms-icon name="edit" class="w-6 h-6 text-yellow-600 mb-1" />
                                        <p class="font-semibold text-yellow-700">{{ __('lms.report.permission') }}</p>
                                        <p class="text-xs text-slate-500">{{ __('lms.attendance.permission_desc') }}</p>
                                    </div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="status" value="sick" {{ old('status', $attendance->status) == 'sick' ? 'checked' : '' }} class="w-5 h-5 text-orange-600 focus:ring-orange-500">
                                    <div>
                                        <x-lms-icon name="warning" class="w-6 h-6 text-orange-600 mb-1" />
                                        <p class="font-semibold text-orange-700">{{ __('lms.report.sick') }}</p>
                                        <p class="text-xs text-slate-500">{{ __('lms.attendance.sick_desc') }}</p>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('lms.attendance.notes_optional') }}</label>
                            <textarea name="notes" rows="3" placeholder="{{ __('lms.attendance.notes_ph') }}"
                                class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-lms-notice tone="info">
                            {{ __('lms.attendance.check_in_info', ['deadline' => $attendance->attendance_deadline ? $attendance->attendance_deadline->format('d M Y H:i') : __('lms.attendance.check_in_not_set')]) }}
                        </x-lms-notice>

                        <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="lms-btn-secondary">{{ __('lms.cancel') }}</a>
                            <button type="submit" class="lms-btn-primary">
                                {{ $attendance->status != 'absent' && $attendance->check_in_time ? __('lms.attendance.update_attendance_btn') : __('lms.attendance.submit_btn') }}
                            </button>
                        </div>
                    </form>
                </x-lms-panel>
            </x-lms-section>
        @endif
    </x-lms-page-shell>
</x-app-layout>
