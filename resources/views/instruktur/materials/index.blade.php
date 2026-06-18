<x-app-layout>
    <div class="materials-wrapper lms-page-shell max-w-7xl mx-auto">
        <x-lms-page-header
            title="Perpustakaan Materi"
            :subtitle="$class->title"
            :back-url="route('instruktur.classes.stream', $class)"
            back-label="← Kembali ke Stream"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.materials.create', $class) }}" class="lms-btn-primary btn-3d">+ Materi Baru</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <x-lms-card class="materials-card" title="Daftar Materi" :meta="'Total: ' . $materials->total() . ' item'">
            @if($materials->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                    @foreach($materials as $material)
                        <div class="material-row p-5 transition group">
                            <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="lms-badge lms-badge--info">Meeting {{ $material->meeting_number }}</span>
                                        @if($material->file_path)
                                            <span class="lms-badge lms-badge--success">📎 {{ strtoupper($material->file_type) }}</span>
                                        @endif
                                        @if($material->youtube_url)
                                            <span class="lms-badge lms-badge--danger">🎥 YouTube</span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $material->title }}</h4>
                                    @if($material->description)
                                        <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-2">{{ $material->description }}</p>
                                    @endif
                                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">Uploaded {{ $material->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="action-btn px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium">View</a>
                                    <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="action-btn px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium">Edit</a>
                                    <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}" method="POST" data-lms-confirm="Delete this material? This action cannot be undone." class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40">
                    {{ $materials->links() }}
                </div>
            @else
                <x-lms-empty-state icon="📚" title="No materials added yet" description="Start by creating your first learning material." class="border-0 shadow-none !py-10">
                    <a href="{{ route('instruktur.materials.create', $class) }}" class="lms-btn-primary btn-3d mt-2">Create Material</a>
                </x-lms-empty-state>
            @endif
        </x-lms-card>
    </div>
</x-app-layout>
