<x-app-layout>
    <div class="space-y-5">
        @include('admin.reports._header', [
            'title' => 'Laporan',
            'description' => 'Rekap data sistem BLKK Tanwiriyyah.',
            'hideBack' => true,
        ])

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach([
                ['route' => 'admin.reports.participants', 'icon' => '👥', 'title' => 'Laporan Peserta', 'desc' => 'Data peserta, kelas, sertifikat, submission, absensi'],
                ['route' => 'admin.reports.instructors', 'icon' => '👨‍🏫', 'title' => 'Laporan Instruktur', 'desc' => 'Data instruktur dan jumlah kelas diampu'],
                ['route' => 'admin.reports.classes', 'icon' => '🏫', 'title' => 'Laporan Kelas', 'desc' => 'Informasi kelas, instruktur, peserta, materi, tugas'],
                ['route' => 'admin.reports.attendance', 'icon' => '📅', 'title' => 'Laporan Kehadiran', 'desc' => 'Rekap absensi per kelas'],
                ['route' => 'admin.reports.grades', 'icon' => '📝', 'title' => 'Laporan Nilai', 'desc' => 'Rekap nilai akhir peserta per kelas'],
                ['route' => 'admin.reports.certificates', 'icon' => '📜', 'title' => 'Laporan Sertifikat', 'desc' => 'Daftar sertifikat yang telah diterbitkan'],
            ] as $item)
                <a href="{{ route($item['route']) }}"
                   class="block bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition">
                    <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                    <h2 class="font-semibold text-slate-800">{{ $item['title'] }}</h2>
                    <p class="text-xs text-slate-500 mt-1">{{ $item['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
