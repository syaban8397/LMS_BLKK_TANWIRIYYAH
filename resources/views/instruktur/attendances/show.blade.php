<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        /* Animasi untuk card dan summary */
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        /* Animasi untuk baris tabel */
        @keyframes rowFadeIn {
            0% { opacity: 0; transform: translateX(-8px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .show-attendance-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Summary cards */
        .summary-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .summary-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(2deg);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.15);
        }
        /* Stagger delay untuk 4 summary cards */
        .summary-card:nth-child(1) { animation-delay: 0.05s; }
        .summary-card:nth-child(2) { animation-delay: 0.1s; }
        .summary-card:nth-child(3) { animation-delay: 0.15s; }
        .summary-card:nth-child(4) { animation-delay: 0.2s; }

        /* Table card 3D */
        .table-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.25s;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .table-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.12);
        }

        /* Baris tabel */
        .attendance-row {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .attendance-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }
        /* Stagger delay untuk baris (maksimal 50) */
        .attendance-row:nth-child(1) { animation-delay: 0.3s; }
        .attendance-row:nth-child(2) { animation-delay: 0.33s; }
        .attendance-row:nth-child(3) { animation-delay: 0.36s; }
        .attendance-row:nth-child(4) { animation-delay: 0.39s; }
        .attendance-row:nth-child(5) { animation-delay: 0.42s; }
        .attendance-row:nth-child(6) { animation-delay: 0.45s; }
        .attendance-row:nth-child(7) { animation-delay: 0.48s; }
        .attendance-row:nth-child(8) { animation-delay: 0.51s; }
        .attendance-row:nth-child(9) { animation-delay: 0.54s; }
        .attendance-row:nth-child(10) { animation-delay: 0.57s; }
        .attendance-row:nth-child(11) { animation-delay: 0.6s; }
        .attendance-row:nth-child(12) { animation-delay: 0.63s; }
        .attendance-row:nth-child(13) { animation-delay: 0.66s; }
        .attendance-row:nth-child(14) { animation-delay: 0.69s; }
        .attendance-row:nth-child(15) { animation-delay: 0.72s; }
        .attendance-row:nth-child(16) { animation-delay: 0.75s; }
        .attendance-row:nth-child(17) { animation-delay: 0.78s; }
        .attendance-row:nth-child(18) { animation-delay: 0.81s; }
        .attendance-row:nth-child(19) { animation-delay: 0.84s; }
        .attendance-row:nth-child(20) { animation-delay: 0.87s; }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Info deadline box */
        .deadline-info {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.03s;
            transition: all 0.3s ease;
        }
        .deadline-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
        }
    </style>

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
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('error') }}
            </div>
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