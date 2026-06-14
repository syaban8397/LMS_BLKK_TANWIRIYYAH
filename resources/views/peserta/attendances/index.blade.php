{{-- resources/views/peserta/attendances/index.blade.php --}}
<x-app-layout>
    <div class="peserta-attendance-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$class->title . ' - Attendance'"
            subtitle="Submit your attendance for each meeting"
            :back-url="route('peserta.classes.stream', $class)"
            back-label="← Back to Class"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <x-lms-card class="attendance-card p-0" title="Attendance Sessions" meta="You can submit attendance until the specified deadline">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 text-left">Meeting</th>
                            <th class="px-5 py-3 text-left">Date</th>
                            <th class="px-5 py-3 text-center">Your Status</th>
                            <th class="px-5 py-3 text-center">Submitted Via</th>
                            <th class="px-5 py-3 text-center">Check In Time</th>
                            <th class="px-5 py-3 text-center">Deadline</th>
                            <th class="px-5 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/55">
                        @forelse($attendances as $attendance)
                            @php
                                $deadline = $attendance->attendance_deadline;
                                $hasStarted = now()->gte($attendance->attendance_date);
                                $canSubmit = $hasStarted && $deadline && now()->lessThanOrEqualTo($deadline);
                                $isNotStarted = !$hasStarted;
                                $isModifiedByInstructor = $attendance->submission_type == 'instructor';
                                $isSubmitted = $attendance->status != 'absent' || $attendance->check_in_time;
                            @endphp
                            <tr class="attendance-row transition">
                                <td class="px-5 py-4 font-medium text-slate-800 dark:text-slate-100">Meeting {{ $attendance->meeting_number }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y H:i') }}</td>
                                <td class="px-5 py-4 text-center">
                                    @switch($attendance->status)
                                        @case('present') <span class="lms-badge lms-badge--success">✅ Present</span> @break
                                        @case('permission') <span class="lms-badge lms-badge--warning">📝 Permission</span> @break
                                        @case('sick') <span class="lms-badge lms-badge--warning">🤒 Sick</span> @break
                                        @default <span class="lms-badge lms-badge--danger">❌ Absent</span>
                                    @endswitch
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($attendance->submission_type == 'self')
                                        <span class="lms-badge lms-badge--info">📱 Self</span>
                                    @else
                                        <span class="lms-badge lms-badge--warning">✏️ By Instructor</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center text-slate-600 dark:text-slate-300">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if($deadline)
                                        @if($canSubmit)
                                            <span class="text-xs text-green-600 dark:text-green-400 font-medium">{{ $deadline->format('d M Y H:i') }}</span>
                                        @else
                                            <span class="text-xs text-red-500 dark:text-red-400 font-medium">Closed</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-400">No deadline</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($canSubmit && !$isModifiedByInstructor)
                                        <a href="{{ route('peserta.attendances.show', [$class, $attendance->meeting_number]) }}"
                                           class="lms-btn-primary btn-3d px-3 py-1.5 text-xs">
                                            {{ $isSubmitted ? 'Edit' : 'Submit' }}
                                        </a>
                                    @elseif($isNotStarted)
                                        <span class="lms-badge lms-badge--info">Belum dimulai</span>
                                    @elseif($isModifiedByInstructor)
                                        <span class="lms-badge lms-badge--warning">Locked by Instructor</span>
                                    @else
                                        <span class="lms-badge">Closed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-500 dark:text-slate-400">
                                    No attendance sessions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-lms-card>
    </div>
</x-app-layout>
