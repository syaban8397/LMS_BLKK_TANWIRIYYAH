<x-app-layout>
    <div class="space-y-5">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sertifikat Saya</h1>
            <p class="text-sm text-slate-500 mt-0.5">Daftar sertifikat yang telah diterbitkan untuk Anda.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Kelas / Program</th>
                        <th class="px-4 py-3 text-left">Nomor Sertifikat</th>
                        <th class="px-4 py-3 text-center">Tanggal Terbit</th>
                        <th class="px-4 py-3 text-center">Kehadiran</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($certificates as $certificate)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $certificate->class->title }}</div>
                                <div class="text-xs text-slate-500">{{ $certificate->class->program->name }}</div>
                            </td>
                            <td class="px-4 py-3 text-xs font-mono text-slate-600">{{ $certificate->certificate_number }}</td>
                            <td class="px-4 py-3 text-center text-slate-600">{{ $certificate->issued_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-center text-blue-700 font-medium">{{ $certificate->attendance_percentage }}%</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('peserta.certificates.download', $certificate) }}"
                                   class="px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-xs font-medium">
                                    📜 Cetak / Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                Belum ada sertifikat. Sertifikat akan tersedia setelah Anda ditandai lulus oleh admin atau instruktur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($certificates->hasPages())
                <div class="px-4 py-3 border-t">{{ $certificates->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
