<x-app-layout>
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Rekap Kehadiran — {{ $class->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->program->name }} · {{ $class->instructor->name }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.attendance.export', $class) }}"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.attendance') }}"
                   class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Peserta</th>
                        <th class="px-4 py-3 text-center">Hadir</th>
                        <th class="px-4 py-3 text-center">Izin</th>
                        <th class="px-4 py-3 text-center">Sakit</th>
                        <th class="px-4 py-3 text-center">Alpha</th>
                        @foreach($meetings as $meeting)
                            <th class="px-4 py-3 text-center">P{{ $meeting->meeting_number }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attendanceMatrix as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $row['name'] }}</td>
                            <td class="px-4 py-3 text-center text-green-700">{{ $row['present_count'] }}</td>
                            <td class="px-4 py-3 text-center text-amber-700">{{ $row['permission_count'] }}</td>
                            <td class="px-4 py-3 text-center text-blue-700">{{ $row['sick_count'] }}</td>
                            <td class="px-4 py-3 text-center text-red-700">{{ $row['absent_count'] }}</td>
                            @foreach($meetings as $meeting)
                                <td class="px-4 py-3 text-center text-xs capitalize">{{ $row['attendances'][$meeting->meeting_number] ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ 5 + $meetings->count() }}" class="py-10 text-center text-slate-400">Belum ada data absensi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
