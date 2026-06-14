<x-app-layout>
<div class="show-attendance-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Meeting {{ $meetingNumber }} - Attendance</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} • {{ \Carbon\Carbon::parse($meetingDate)->format('d F Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.attendances.edit', [$class, $meetingNumber]) }}" class="btn-3d px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                    ✏️ Edit
                </a>
                <a href="{{ route('instruktur.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Sessions
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        {{-- Deadline Info --}}
        @if(isset($deadline) && $deadline)
            <div class="deadline-info bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg p-3 text-sm">
                <strong>Attendance Deadline:</strong> {{ $deadline->format('d F Y H:i') }}
                @if(now()->gt($deadline))
                    <span class="ml-2 text-red-600 font-semibold">(Closed – students cannot submit/change)</span>
                @else
                    <span class="ml-2 text-green-600 font-semibold">(Open – students can submit until this time)</span>
                @endif
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="summary-card bg-green-50 rounded-xl p-4 text-center border border-green-200">
                <p class="text-3xl font-bold text-green-700">{{ $summary['present'] }}</p>
                <p class="text-sm text-green-600">✅ Present</p>
            </div>
            <div class="summary-card bg-yellow-50 rounded-xl p-4 text-center border border-yellow-200">
                <p class="text-3xl font-bold text-yellow-700">{{ $summary['permission'] }}</p>
                <p class="text-sm text-yellow-600">📝 Permission</p>
            </div>
            <div class="summary-card bg-orange-50 rounded-xl p-4 text-center border border-orange-200">
                <p class="text-3xl font-bold text-orange-700">{{ $summary['sick'] }}</p>
                <p class="text-sm text-orange-600">🤒 Sick</p>
            </div>
            <div class="summary-card bg-red-50 rounded-xl p-4 text-center border border-red-200">
                <p class="text-3xl font-bold text-red-700">{{ $summary['absent'] }}</p>
                <p class="text-sm text-red-600">❌ Absent</p>
            </div>
        </div>

        {{-- Student Details Table --}}
        <div class="table-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Student Details</h3>
                <p class="text-xs text-slate-500 mt-0.5">Attendance status per student</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Student</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Submission Type</th>
                            <th class="px-6 py-4 text-left">Check In Time</th>
                            <th class="px-6 py-4 text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            @php
                                $statusLabels = ['present' => 'Present', 'permission' => 'Permission', 'sick' => 'Sick', 'absent' => 'Absent'];
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
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">📱 Self</span>
                                    @else
                                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">✏️ By Instructor</span>
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