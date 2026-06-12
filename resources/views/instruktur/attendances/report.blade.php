<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        /* Animasi untuk card */
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        /* Animasi untuk baris tabel */
        @keyframes rowFadeIn {
            0% { opacity: 0; transform: translateX(-8px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .report-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Table card 3D */
        .report-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .report-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.12);
        }

        /* Baris tabel */
        .report-row {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .report-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }
        /* Stagger delay untuk baris (maksimal 50) */
        .report-row:nth-child(1) { animation-delay: 0.1s; }
        .report-row:nth-child(2) { animation-delay: 0.13s; }
        .report-row:nth-child(3) { animation-delay: 0.16s; }
        .report-row:nth-child(4) { animation-delay: 0.19s; }
        .report-row:nth-child(5) { animation-delay: 0.22s; }
        .report-row:nth-child(6) { animation-delay: 0.25s; }
        .report-row:nth-child(7) { animation-delay: 0.28s; }
        .report-row:nth-child(8) { animation-delay: 0.31s; }
        .report-row:nth-child(9) { animation-delay: 0.34s; }
        .report-row:nth-child(10) { animation-delay: 0.37s; }
        .report-row:nth-child(11) { animation-delay: 0.4s; }
        .report-row:nth-child(12) { animation-delay: 0.43s; }
        .report-row:nth-child(13) { animation-delay: 0.46s; }
        .report-row:nth-child(14) { animation-delay: 0.49s; }
        .report-row:nth-child(15) { animation-delay: 0.52s; }
        .report-row:nth-child(16) { animation-delay: 0.55s; }
        .report-row:nth-child(17) { animation-delay: 0.58s; }
        .report-row:nth-child(18) { animation-delay: 0.61s; }
        .report-row:nth-child(19) { animation-delay: 0.64s; }
        .report-row:nth-child(20) { animation-delay: 0.67s; }
        .report-row:nth-child(21) { animation-delay: 0.7s; }
        .report-row:nth-child(22) { animation-delay: 0.73s; }
        .report-row:nth-child(23) { animation-delay: 0.76s; }
        .report-row:nth-child(24) { animation-delay: 0.79s; }
        .report-row:nth-child(25) { animation-delay: 0.82s; }
        .report-row:nth-child(26) { animation-delay: 0.85s; }
        .report-row:nth-child(27) { animation-delay: 0.88s; }
        .report-row:nth-child(28) { animation-delay: 0.91s; }
        .report-row:nth-child(29) { animation-delay: 0.94s; }
        .report-row:nth-child(30) { animation-delay: 0.97s; }

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
    </style>

    <div class="report-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Attendance Report</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} • Student attendance matrix</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Sessions
                </a>
            </div>
        </div>

        {{-- Flash Messages (if any) --}}
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

        {{-- Report Card --}}
        <div class="report-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Student Attendance Matrix</h3>
                <p class="text-xs text-slate-500 mt-0.5">Per meeting status summary for all students</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-4 py-3 text-left">Student</th>
                            @foreach($meetings as $meeting)
                                <th class="px-3 py-3 text-center">
                                    M{{ $meeting->meeting_number }}<br>
                                    <span class="text-xs">{{ $meeting->attendance_date->format('d/m') }}</span>
                                </th>
                            @endforeach
                            <th class="px-3 py-3 text-center">✅</th>
                            <th class="px-3 py-3 text-center">📝</th>
                            <th class="px-3 py-3 text-center">🤒</th>
                            <th class="px-3 py-3 text-center">❌</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceMatrix as $studentId => $data)
                            <tr class="report-row border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-slate-800">{{ $data['name'] }}</p>
                                </td>
                                @foreach($meetings as $meeting)
                                    @php
                                        $status = $data['attendances'][$meeting->meeting_number] ?? '-';
                                        $colors = [
                                            'present'    => 'bg-green-100 text-green-700',
                                            'permission' => 'bg-yellow-100 text-yellow-700',
                                            'sick'       => 'bg-orange-100 text-orange-700',
                                            'absent'     => 'bg-red-100 text-red-700',
                                            '-'          => 'bg-slate-100 text-slate-400'
                                        ];
                                        $icons = [
                                            'present'    => '✓',
                                            'permission' => '📝',
                                            'sick'       => '🤒',
                                            'absent'     => '✗',
                                            '-'          => '−'
                                        ];
                                    @endphp
                                    <td class="px-3 py-3 text-center">
                                        <span class="inline-block w-8 h-8 leading-8 rounded-full text-xs font-semibold {{ $colors[$status] }}">
                                            {{ $icons[$status] }}
                                        </span>
                                    </td>
                                @endforeach
                                <td class="px-3 py-3 text-center font-bold text-green-700">{{ $data['present_count'] }}</td>
                                <td class="px-3 py-3 text-center font-bold text-yellow-700">{{ $data['permission_count'] }}</td>
                                <td class="px-3 py-3 text-center font-bold text-orange-700">{{ $data['sick_count'] }}</td>
                                <td class="px-3 py-3 text-center font-bold text-red-700">{{ $data['absent_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>