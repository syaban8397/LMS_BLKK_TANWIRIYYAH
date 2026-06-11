<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-900 via-teal-900 to-cyan-900 -mx-6 -mt-6 px-6 py-12 rounded-b-3xl shadow-2xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-full px-3 py-1 text-xs text-white mb-3">
                        <span class="animate-pulse">●</span> Learning Materials
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">{{ $class->title }}</h1>
                    <p class="text-emerald-100 mt-2 text-sm md:text-base">Manage all learning resources for this class</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('instruktur.materials.create', $class) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl text-white font-semibold hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Material
                    </a>
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white font-medium hover:bg-white/20 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Stream
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-8">
        @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 text-emerald-800 p-5 rounded-2xl shadow-md flex items-center gap-3 backdrop-blur-sm">
                <div class="p-2 bg-emerald-100 rounded-full"><svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                {{ session('success') }}
            </div>
        @endif

        <!-- Materials Grid / List (Premium Card View) -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100 flex justify-between items-center flex-wrap gap-3">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Materials Library
                </h3>
                <div class="text-sm text-gray-500">Total: {{ $materials->total() }} items</div>
            </div>

            @if($materials->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($materials as $material)
                    <div class="p-6 hover:bg-gradient-to-r hover:from-emerald-50/30 hover:to-transparent transition group">
                        <div class="flex items-start justify-between gap-4 flex-wrap md:flex-nowrap">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-3 flex-wrap">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold {{ $material->meeting_number % 2 == 0 ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Meeting {{ $material->meeting_number }}
                                    </span>
                                    @if($material->file_path)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-medium">📎 {{ strtoupper($material->file_type) }}</span>
                                    @endif
                                    @if($material->youtube_url)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">🎥 YouTube</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-gray-800 text-xl mb-2 group-hover:text-emerald-700 transition">{{ $material->title }}</h4>
                                @if($material->description)
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $material->description }}</p>
                                @endif
                                <div class="mt-3 text-xs text-gray-400">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-sm font-semibold transition shadow-md hover:scale-105 transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                                <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition shadow-md hover:scale-105 transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}" method="POST" onsubmit="return confirm('Delete this material? This action cannot be undone.');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition shadow-md hover:scale-105 transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    {{ $materials->links() }}
                </div>
            @else
                <div class="p-16 text-center">
                    <div class="flex flex-col items-center gap-4 text-gray-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="text-lg font-semibold">No materials added yet</p>
                        <p class="text-sm">Start by creating your first learning material.</p>
                        <a href="{{ route('instruktur.materials.create', $class) }}" class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Create Material
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>