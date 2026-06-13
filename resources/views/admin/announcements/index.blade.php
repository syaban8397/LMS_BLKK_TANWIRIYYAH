<x-app-layout>
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Pengumuman Kelas</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola pengumuman untuk kelas tertentu.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">Kelas</th>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-left">Instruktur</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Jumlah Pengumuman</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classes as $class)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $class->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $class->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->program->name }}</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->instructor->name }}</td>
                                <td class="px-4 py-3 text-center">
                                    @switch($class->status)
                                        @case('active')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                                            @break
                                        @case('draft')
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Draft</span>
                                            @break
                                        @case('completed')
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Completed</span>
                                            @break
                                        @default
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">{{ ucfirst($class->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                        {{ $class->announcements_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('admin.announcements.show', $class) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400 text-sm">
                                    Belum ada kelas. Buat kelas terlebih dahulu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($classes->hasPages())
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $classes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
