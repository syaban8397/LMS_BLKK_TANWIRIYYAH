<x-app-layout>
    <div class="space-y-6">
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
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Report Card --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
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
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
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