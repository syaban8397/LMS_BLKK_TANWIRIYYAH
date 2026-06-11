<x-app-layout>
    {{-- Tombol aksi di kanan atas tanpa header --}}
    <div class="flex justify-end gap-3 mb-6">
        <a href="{{ route('instruktur.materials.create', $class) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Material
        </a>
        <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Stream
        </a>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card daftar materi --}}
        <div class="dashboard-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-3 border-b border-slate-200 flex justify-between items-center flex-wrap gap-2">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Materials Library
                </h3>
                <div class="text-xs text-slate-500">Total: {{ $materials->total() }} items</div>
            </div>

            @if($materials->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($materials as $material)
                    <div class="p-5 hover:bg-slate-50 transition group">
                        <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $material->meeting_number % 2 == 0 ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Meeting {{ $material->meeting_number }}
                                    </span>
                                    @if($material->file_path)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-lg text-xs">📎 {{ strtoupper($material->file_type) }}</span>
                                    @endif
                                    @if($material->youtube_url)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 rounded-lg text-xs">🎥 YouTube</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-blue-600 transition">{{ $material->title }}</h4>
                                @if($material->description)
                                    <p class="text-slate-600 text-sm line-clamp-2">{{ $material->description }}</p>
                                @endif
                                <p class="mt-2 text-xs text-slate-400">Uploaded {{ $material->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium transition shadow-sm">View</a>
                                <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium transition shadow-sm">Edit</a>
                                <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}" method="POST" onsubmit="return confirm('Delete this material? This action cannot be undone.');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition shadow-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $materials->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="flex flex-col items-center gap-2 text-slate-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="font-semibold">No materials added yet</p>
                        <p class="text-sm">Start by creating your first learning material.</p>
                        <a href="{{ route('instruktur.materials.create', $class) }}" class="btn-3d mt-2 inline-flex items-center gap-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">Create Material</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>