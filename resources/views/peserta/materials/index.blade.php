<x-app-layout>
    <div class="space-y-6">
        {{-- Header Sederhana dengan Tombol Back --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $class->title }} - Materials</h1>
                <p class="text-sm text-slate-500 mt-0.5">Learning materials for this class.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages (opsional) --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Materials Card (3D) --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Materials ({{ $materials->total() }})</h3>
                <span class="text-xs text-slate-400">Learning resources</span>
            </div>

            @if($materials->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($materials as $material)
                        <div class="p-5 hover:bg-slate-50 transition group">
                            <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            Meeting {{ $material->meeting_number }}
                                        </span>
                                        @if($material->file_path)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">📎 {{ strtoupper($material->file_type) }}</span>
                                        @endif
                                        @if($material->youtube_url)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">🎥 YouTube</span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-blue-600 transition">{{ $material->title }}</h4>
                                    @if($material->description)
                                        <p class="text-slate-600 text-sm line-clamp-2">{{ $material->description }}</p>
                                    @endif
                                    <p class="mt-2 text-xs text-slate-400">By {{ $material->creator->name }} • {{ $material->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($materials->hasPages())
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
                        {{ $materials->links() }}
                    </div>
                @endif
            @else
                <div class="p-8 text-center">
                    <div class="flex flex-col items-center text-slate-400">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="text-sm">No materials available yet.</p>
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