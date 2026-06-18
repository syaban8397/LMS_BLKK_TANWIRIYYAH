<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            title="Sertifikat Kelas"
            subtitle="Kelola kelulusan dan penerbitan sertifikat per kelas."
            :back-url="route('admin.dashboard')"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Program</th>
                        <th class="px-4 py-3 text-left">Instruktur</th>
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
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $class->instructor->name }}</td>
                            <td class="px-4 py-3 text-center font-bold text-orange-600">{{ $class->certificates_count }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.certificates.show', $class) }}"
                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">Kelola</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-10 text-center text-slate-400">Belum ada kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($classes->hasPages())
                <div class="px-4 py-3 border-t">{{ $classes->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
