<x-app-layout>
    <div class="space-y-5">
        @include('admin.reports._header', [
            'title' => 'Laporan Nilai',
            'description' => 'Rekap nilai akhir peserta per kelas.',
        ])

        <div class="flex justify-end">
            <a href="{{ route('admin.reports.grades.export') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                Export Excel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Peserta</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-center">Nilai Tugas</th>
                        <th class="px-4 py-3 text-center">Nilai Absensi</th>
                        <th class="px-4 py-3 text-center">Nilai Akhir</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($grades as $grade)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $grade->participant->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $grade->participant->email ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $grade->class->title ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $grade->assignment_score }}</td>
                            <td class="px-4 py-3 text-center">{{ $grade->attendance_score }}</td>
                            <td class="px-4 py-3 text-center font-semibold">{{ $grade->final_score }}</td>
                            <td class="px-4 py-3 text-center text-xs">
                                @if($grade->status === 'pass') Lulus
                                @elseif($grade->status === 'fail') Tidak Lulus
                                @else - @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-slate-400">Belum ada data nilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
