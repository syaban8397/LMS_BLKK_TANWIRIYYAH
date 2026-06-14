<x-app-layout>
    <div class="space-y-5">
        @include('admin.reports._header', [
            'title' => 'Laporan Kelas',
            'description' => 'Informasi kelas, program, instruktur, dan rekap aktivitas.',
        ])

        <div class="flex justify-end">
            <a href="{{ route('admin.reports.classes.export') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                Export Excel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Program</th>
                        <th class="px-4 py-3 text-left">Instruktur</th>
                        <th class="px-4 py-3 text-center">Peserta</th>
                        <th class="px-4 py-3 text-center">Materi</th>
                        <th class="px-4 py-3 text-center">Tugas</th>
                        <th class="px-4 py-3 text-center">Sertifikat</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($classes as $class)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $class->title }}</div>
                                <div class="text-xs text-slate-500">{{ $class->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $class->program->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $class->instructor->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $class->participants_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $class->materials_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $class->assignments_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $class->certificates_count }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.reports.classes.show', $class) }}"
                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-10 text-center text-slate-400">Belum ada kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
