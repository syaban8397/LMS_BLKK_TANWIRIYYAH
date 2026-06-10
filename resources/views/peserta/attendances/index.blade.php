{{-- resources/views/peserta/attendances/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $class->title }} - Attendance</h2>
                <p class="text-sm text-slate-500 mt-1">Submit your attendance for each meeting</p>
            </div>
            <a href="{{ route('peserta.classes.stream', $class) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">Back to Class</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Attendance Sessions</h3>
                <p class="text-sm text-slate-500 mt-1">You can submit attendance until the day after the meeting date</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Meeting</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-center">Your Status</th>
                            <th class="px-6 py-4 text-center">Submitted Via</th>
                            <th class="px-6 py-4 text-center">Check In Time</th>
                            <th class="px-6 py-4 text-center">Deadline</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            @php
                                $deadline = \Carbon\Carbon::parse($attendance->attendance_date)->addDay();
                                $canSubmit = $deadline->isFuture();
                                $isModifiedByInstructor = $attendance->submission_type == 'instructor';
                                $statusLabels = ['present' => '✅ Present', 'permission' => '📝 Permission', 'sick' => '🤒 Sick', 'absent' => '❌ Absent'];
                                $statusColors = ['present' => 'bg-green-100 text-green-700', 'permission' => 'bg-yellow-100 text-yellow-700', 'sick' => 'bg-orange-100 text-orange-700', 'absent' => 'bg-red-100 text-red-700'];
                                $isSubmitted = $attendance->status != 'absent' || $attendance->check_in_time;
                            @endphp
                            <tr class="border-t hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">Meeting {{ $attendance->meeting_number }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$attendance->status] }}">
                                        {{ $statusLabels[$attendance->status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($attendance->submission_type == 'self')
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">📱 Self</span>
                                    @else
                                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">✏️ By Instructor</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $attendance->check_in_time ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($canSubmit)
                                        <span class="text-xs text-green-600">{{ $deadline->format('d M Y H:i') }}</span>
                                    @else
                                        <span class="text-xs text-red-500">Closed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($canSubmit && !$isModifiedByInstructor)
                                        <a href="{{ route('peserta.attendances.show', [$class, $attendance->meeting_number]) }}" 
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm transition">
                                            {{ $isSubmitted ? 'Edit' : 'Submit' }}
                                        </a>
                                    @elseif($isModifiedByInstructor)
                                        <span class="text-xs text-amber-600 bg-amber-50 px-3 py-2 rounded-xl">Locked by Instructor</span>
                                    @else
                                        <span class="text-xs text-slate-400 bg-slate-100 px-3 py-2 rounded-xl">Closed</span>
                                    @endif
                                </td>
                            </table>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-slate-400 text-lg mb-2">📅 No attendance sessions yet</div>
                                <p class="text-slate-500 text-sm">The instructor hasn't created any attendance sessions for this class.</p>
                             </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>