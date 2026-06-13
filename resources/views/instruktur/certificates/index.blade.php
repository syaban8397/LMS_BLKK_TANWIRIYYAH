<x-app-layout>
    <div class="space-y-5">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sertifikat Kelas Saya</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola kelulusan dan cetak sertifikat peserta.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Program</th>
                        <th class="px-4 py-3 text-center">Sertifikat Terbit</th>
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
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $class->program->name }}</td>
                            <td class="px-4 py-3 text-center font-bold text-orange-600">{{ $class->certificates_count }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('instruktur.certificates.show', $class) }}"
                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">Kelola</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-400">Anda belum memiliki kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($classes->hasPages())
                <div class="px-4 py-3 border-t">{{ $classes->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
