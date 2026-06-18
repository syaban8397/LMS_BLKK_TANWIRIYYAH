<x-app-layout>
    <div class="peserta-materials-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$class->title . ' - Materials'"
            subtitle="Learning materials for this class."
            :back-url="route('peserta.classes.stream', $class)"
            back-label="← Kembali ke Kelas"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <x-lms-card class="materials-card p-0" title="Materials ({{ $materials->total() }})" meta="Learning resources">
            @if($materials->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                    @foreach($materials as $material)
                        <div class="material-row p-5 transition group">
                            <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-4">
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
                                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">By {{ $material->creator->name }} • {{ $material->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="lms-btn-primary btn-3d px-4 py-2 text-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($materials->hasPages())
                    <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40">
                        {{ $materials->links() }}
                    </div>
                @endif
            @else
                <x-lms-empty-state icon="📚" title="No materials available yet" class="border-0 shadow-none !py-10" />
            @endif
        </x-lms-card>
    </div>
</x-app-layout>
