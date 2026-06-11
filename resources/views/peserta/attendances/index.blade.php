{{-- resources/views/peserta/attendances/index.blade.php --}}
<x-app-layout>
    <div class="space-y-6">
        {{-- Header Sederhana dengan Tombol Back --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $class->title }} - Attendance</h1>
                <p class="text-sm text-slate-500 mt-0.5">Submit your attendance for each meeting</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Tabel Attendance (dalam Dashboard Card 3D) --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Attendance Sessions</h3>
                <p class="text-xs text-slate-500 mt-0.5">You can submit attendance until the specified deadline</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
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
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendances as $attendance)
                            @php
                                $deadline = $attendance->attendance_deadline;
                                $canSubmit = $deadline && now()->lessThanOrEqualTo($deadline);
                                $isModifiedByInstructor = $attendance->submission_type == 'instructor';
                                $statusLabels = ['present' => '✅ Present', 'permission' => '📝 Permission', 'sick' => '🤒 Sick', 'absent' => '❌ Absent'];
                                $statusColors = ['present' => 'bg-green-100 text-green-700', 'permission' => 'bg-yellow-100 text-yellow-700', 'sick' => 'bg-orange-100 text-orange-700', 'absent' => 'bg-red-100 text-red-700'];
                                $isSubmitted = $attendance->status != 'absent' || $attendance->check_in_time;
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-medium text-slate-800">Meeting {{ $attendance->meeting_number }}</td>
                                <td class="px-5 py-4 text-slate-600 text-sm">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y H:i') }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$attendance->status] }}">
                                        {{ $statusLabels[$attendance->status] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($attendance->submission_type == 'self')
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">📱 Self</span>
                                    @else
                                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">✏️ By Instructor</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center text-slate-600 text-sm">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if($deadline)
                                        @if($canSubmit)
                                            <span class="text-xs text-green-600 font-medium">{{ $deadline->format('d M Y H:i') }}</span>
                                        @else
                                            <span class="text-xs text-red-500 font-medium">Closed</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">No deadline</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($canSubmit && !$isModifiedByInstructor)
                                        <a href="{{ route('peserta.attendances.show', [$class, $attendance->meeting_number]) }}" 
                                           class="btn-3d inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                            {{ $isSubmitted ? 'Edit' : 'Submit' }}
                                        </a>
                                    @elseif($isModifiedByInstructor)
                                        <span class="text-xs text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg">Locked by Instructor</span>
                                    @else
                                        <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg">Closed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center text-slate-400">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-sm">No attendance sessions yet.</p>
                                        <p class="text-xs text-slate-400 mt-1">The instructor hasn't created any attendance sessions for this class.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>