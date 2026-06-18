<x-app-layout>
<div class="show-attendance-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.attendance.meeting_title_instruktur', ['number' => $meetingNumber])"
            :subtitle="$class->title . ' • ' . \Carbon\Carbon::parse($meetingDate)->format('d F Y H:i')"
            :back-url="route('instruktur.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_sessions')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions'), 'url' => route('instruktur.attendances.index', $class)],
                ['label' => __('lms.attendance.meeting_title_instruktur', ['number' => $meetingNumber])],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.attendances.edit', [$class, $meetingNumber]) }}" class="lms-btn-warning">✏️ {{ __('lms.edit') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        {{-- Deadline Info --}}
        @if(isset($deadline) && $deadline)
            <div class="deadline-info bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg p-3 text-sm">
                <strong>{{ __('lms.attendance.deadline_label') }}</strong> {{ $deadline->format('d F Y H:i') }}
                @if(now()->gt($deadline))
                    <span class="ml-2 text-red-600 font-semibold">{{ __('lms.attendance.closed_students') }}</span>
                @else
                    <span class="ml-2 text-green-600 font-semibold">{{ __('lms.attendance.open_students') }}</span>
                @endif
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="summary-card bg-green-50 rounded-xl p-4 text-center border border-green-200">
                <p class="text-3xl font-bold text-green-700">{{ $summary['present'] }}</p>
                <p class="text-sm text-green-600">✅ {{ __('lms.report.present') }}</p>
            </div>
            <div class="summary-card bg-yellow-50 rounded-xl p-4 text-center border border-yellow-200">
                <p class="text-3xl font-bold text-yellow-700">{{ $summary['permission'] }}</p>
                <p class="text-sm text-yellow-600">📝 {{ __('lms.report.permission') }}</p>
            </div>
            <div class="summary-card bg-orange-50 rounded-xl p-4 text-center border border-orange-200">
                <p class="text-3xl font-bold text-orange-700">{{ $summary['sick'] }}</p>
                <p class="text-sm text-orange-600">🤒 {{ __('lms.report.sick') }}</p>
            </div>
            <div class="summary-card bg-red-50 rounded-xl p-4 text-center border border-red-200">
                <p class="text-3xl font-bold text-red-700">{{ $summary['absent'] }}</p>
                <p class="text-sm text-red-600">❌ {{ __('lms.report.absent') }}</p>
            </div>
        </div>

        {{-- Student Details Table --}}
        <div class="table-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">{{ __('lms.attendance.student_details') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('lms.attendance.status_per_student') }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">{{ __('lms.attendance.student') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.common.status') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.attendance.submission_type') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.attendance.check_in_time') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.attendance.notes_optional') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            @php
                                $statusLabels = [
                                    'present' => __('lms.report.present'),
                                    'permission' => __('lms.report.permission'),
                                    'sick' => __('lms.report.sick'),
                                    'absent' => __('lms.report.absent'),
                                ];
                                $statusColors = ['present' => 'bg-green-100 text-green-700', 'permission' => 'bg-yellow-100 text-yellow-700', 'sick' => 'bg-orange-100 text-orange-700', 'absent' => 'bg-red-100 text-red-700'];
                            @endphp
                            <tr class="attendance-row border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-800">{{ $attendance->participant->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $attendance->participant->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$attendance->status] }}">
                                        {{ $statusLabels[$attendance->status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($attendance->submission_type == 'self')
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">📱 {{ __('lms.attendance.self') }}</span>
                                    @else
                                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">✏️ {{ __('lms.attendance.by_instructor') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
