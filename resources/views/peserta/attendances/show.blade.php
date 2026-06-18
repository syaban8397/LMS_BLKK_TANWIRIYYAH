{{-- resources/views/peserta/attendances/show.blade.php --}}
<x-app-layout>
<div class="peserta-attendance-show-wrapper lms-module-shell space-y-6">
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

        <x-lms-session-flash />

        @php
            $isNotStarted = now()->lt($attendance->attendance_date);
            $statusLabels = [
                'present' => '✅ ' . __('lms.report.present'),
                'permission' => '📝 ' . __('lms.report.permission'),
                'sick' => '🤒 ' . __('lms.report.sick'),
                'absent' => '❌ ' . __('lms.report.absent'),
            ];
            $statusColors = ['present' => 'text-green-600', 'permission' => 'text-yellow-600', 'sick' => 'text-orange-600', 'absent' => 'text-red-600'];
        @endphp
        
        {{-- Card Utama --}}
        @if($attendance->submission_type == 'instructor')
            {{-- Locked by instructor --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>🔒</span> {{ __('lms.attendance.locked_title') }}
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="text-5xl mb-3">🔒</div>
                    <h4 class="text-lg font-bold text-amber-800 mb-2">{{ __('lms.attendance.locked_title') }}</h4>
                    <p class="text-amber-700 mb-4">{{ __('lms.attendance.locked_desc') }}</p>
                    <div class="bg-amber-50 rounded-xl p-4 inline-block border border-amber-200">
                        <p class="text-slate-700">{{ __('lms.attendance.current_status') }} 
                            <span class="font-semibold {{ $statusColors[$attendance->status] }}">{{ $statusLabels[$attendance->status] }}</span>
                        </p>
                        @if($attendance->notes)
                            <p class="text-slate-500 text-sm mt-2">{{ __('lms.assignment.notes_label') }} {{ $attendance->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif($isNotStarted)
        {{-- Sesi belum dimulai --}}
        <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span>⏳</span> {{ __('lms.attendance.session_not_started_title') }}
                </h3>
            </div>
            <div class="p-6 text-center">
                <div class="text-5xl mb-3">⏳</div>
                <h4 class="text-lg font-bold text-blue-800 mb-2">{{ __('lms.attendance.not_time_yet') }}</h4>
                <p class="text-blue-700">{{ __('lms.attendance.session_opens_at', ['datetime' => $attendance->attendance_date->format('d M Y H:i')]) }}</p>
                <p class="text-blue-600 text-sm mt-2">{{ __('lms.attendance.come_back_later') }}</p>
            </div>
        </div>

        @elseif($isExpired)
            {{-- Deadline passed --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>⏰</span> {{ __('lms.attendance.deadline_passed_title') }}
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="text-5xl mb-3">⏰</div>
                    <h4 class="text-lg font-bold text-red-800 mb-2">{{ __('lms.attendance.submission_deadline_passed') }}</h4>
                    <p class="text-red-700">{{ __('lms.attendance.cannot_submit_contact') }}</p>
                    @if($attendance->attendance_deadline)
                        <p class="text-sm text-red-600 mt-3">{{ __('lms.assignment.deadline_was', ['date' => $attendance->attendance_deadline->format('d M Y H:i')]) }}</p>
                    @endif
                </div>
            </div>

        @else
            {{-- Form submit/edit --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📋</span> {{ __('lms.attendance.attendance_form') }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __('lms.attendance.select_status_hint') }}</p>
                </div>
                <div class="p-5">
                    <form action="{{ route('peserta.attendances.submit', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Status Options --}}
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">{{ __('lms.attendance.choose_status') }}</label>
                            <div class="grid md:grid-cols-3 gap-4">
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="status" value="present" {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }} class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                    <div><span class="text-2xl">✅</span><p class="font-semibold text-green-700">{{ __('lms.report.present') }}</p><p class="text-xs text-slate-500">{{ __('lms.attendance.present_desc') }}</p></div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-yellow-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                                    <input type="radio" name="status" value="permission" {{ old('status', $attendance->status) == 'permission' ? 'checked' : '' }} class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                                    <div><span class="text-2xl">📝</span><p class="font-semibold text-yellow-700">{{ __('lms.report.permission') }}</p><p class="text-xs text-slate-500">{{ __('lms.attendance.permission_desc') }}</p></div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="status" value="sick" {{ old('status', $attendance->status) == 'sick' ? 'checked' : '' }} class="w-5 h-5 text-orange-600 focus:ring-orange-500">
                                    <div><span class="text-2xl">🤒</span><p class="font-semibold text-orange-700">{{ __('lms.report.sick') }}</p><p class="text-xs text-slate-500">{{ __('lms.attendance.sick_desc') }}</p></div>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('lms.attendance.notes_optional') }}</label>
                            <textarea name="notes" rows="3" placeholder="{{ __('lms.attendance.notes_ph') }}" 
                                class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="form-group bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-sm text-blue-800 flex items-center gap-2">
                                📌 <span>{{ __('lms.attendance.check_in_info', ['deadline' => $attendance->attendance_deadline ? $attendance->attendance_deadline->format('d M Y H:i') : __('lms.attendance.check_in_not_set')]) }}</span>
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="lms-btn-secondary">{{ __('lms.cancel') }}</a>
                            <button type="submit" class="lms-btn-primary">
                                {{ $attendance->status != 'absent' && $attendance->check_in_time ? __('lms.attendance.update_attendance_btn') : __('lms.attendance.submit_btn') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
