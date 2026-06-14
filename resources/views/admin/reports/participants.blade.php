<x-app-layout>
    <div class="space-y-5">
        @include('admin.reports._header', [
            'title' => 'Laporan Peserta',
            'description' => 'Rekap seluruh peserta terdaftar.',
        ])

        <div class="flex justify-end">
            <a href="{{ route('admin.reports.participants.export') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                Export Excel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-center">Kelas</th>
                        <th class="px-4 py-3 text-center">Sertifikat</th>
                        <th class="px-4 py-3 text-center">Submission</th>
                        <th class="px-4 py-3 text-center">Absensi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($participants as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-center">{{ $user->class_participants_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $user->certificates_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $user->submissions_count }}</td>
                            <td class="px-4 py-3 text-center">{{ $user->attendances_count }}</td>
                            <td class="px-4 py-3 text-center text-xs">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-10 text-center text-slate-400">Belum ada peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
