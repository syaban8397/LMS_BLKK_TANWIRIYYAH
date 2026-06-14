<x-app-layout>
    <div class="space-y-5">
        @include('admin.reports._header', [
            'title' => 'Laporan Sertifikat',
            'description' => 'Daftar sertifikat yang telah diterbitkan.',
        ])

        <div class="flex justify-end">
            <a href="{{ route('admin.reports.certificates.export') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                Export Excel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Nomor Sertifikat</th>
                        <th class="px-4 py-3 text-left">Peserta</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Program</th>
                        <th class="px-4 py-3 text-center">Nilai</th>
                        <th class="px-4 py-3 text-center">Terbit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($certificates as $certificate)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-mono text-xs text-slate-700">{{ $certificate->certificate_number }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $certificate->participant->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $certificate->participant->email ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $certificate->class->title ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $certificate->class->program->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $certificate->final_score }}</td>
                            <td class="px-4 py-3 text-center text-xs">{{ $certificate->issued_at?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-slate-400">Belum ada sertifikat diterbitkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
