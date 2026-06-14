<x-app-layout>
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Laporan Kelas — {{ $class->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ $class->program->name }} · Instruktur: {{ $class->instructor->name }} · Kode: {{ $class->code }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.classes.export-class', $class) }}"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.classes') }}"
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
                        <th class="px-4 py-3 text-center">Absensi</th>
                        <th class="px-4 py-3 text-center">Pengumpulan Tugas</th>
                        <th class="px-4 py-3 text-center">Status Kelulusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $row)
                        @php $status = $row['final_grade']?->status; @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $row['participant']->name }}</div>
                                <div class="text-xs text-slate-500">{{ $row['participant']->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="font-semibold text-blue-700">{{ $row['attendance_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_meetings'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="font-semibold text-purple-700">{{ $row['submission_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_assignments'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-xs font-medium">
                                @if($status === 'pass')
                                    <span class="text-green-600">Lulus</span>
                                @elseif($status === 'fail')
                                    <span class="text-red-600">Tidak Lulus</span>
                                @else
                                    <span class="text-slate-400">Belum Ditentukan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-400">Belum ada peserta di kelas ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
