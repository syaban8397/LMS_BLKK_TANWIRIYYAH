<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-sky-900 via-blue-900 to-indigo-900 -mx-6 -mt-6 px-6 py-12 rounded-b-3xl shadow-2xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-full px-3 py-1 text-xs text-white mb-3">
                        <span class="animate-pulse">●</span> Material Preview
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">{{ $material->title }}</h1>
                    <p class="text-sky-100 mt-2 text-sm md:text-base">{{ $class->title }} • Meeting {{ $material->meeting_number }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500/90 backdrop-blur-md border border-amber-400/50 rounded-2xl text-white font-semibold hover:bg-amber-600 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('instruktur.materials.index', $class) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white font-medium hover:bg-white/20 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Materials
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-8">
        <!-- Material Information Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Material Details
                </h3>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-1">Title</p>
                        <p class="text-gray-800 text-2xl font-bold">{{ $material->title }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-1">Meeting</p>
                            <p class="text-gray-800 font-bold text-xl">#{{ $material->meeting_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-1">Created By</p>
                            <p class="text-gray-800 font-bold">{{ $material->creator->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-1">Created At</p>
                            <p class="text-gray-800">{{ $material->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-1">Last Update</p>
                            <p class="text-gray-800">{{ $material->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                @if($material->description)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Description</p>
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $material->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- File Attachment Card (if exists) -->
        @if($material->file_path)
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-white px-6 py-5 border-b border-gray-100">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6M9 21H4a1 1 0 01-1-1V4a1 1 0 011-1h10l6 6v11a1 1 0 01-1 1h-3M15 3v6h6"></path></svg>
                    Attachment File
                </h3>
            </div>
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-5 bg-gradient-to-r from-emerald-50/50 to-transparent rounded-2xl border border-emerald-100">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl shadow-md">
                            @php
                                $icon = match(strtolower($material->file_type)) {
                                    'pdf' => '📄',
                                    'doc', 'docx' => '📝',
                                    'xls', 'xlsx' => '📊',
                                    'ppt', 'pptx' => '🎯',
                                    'zip', 'rar' => '📦',
                                    'jpg', 'jpeg', 'png', 'gif' => '🖼️',
                                    'mp4', 'mov', 'avi' => '🎬',
                                    default => '📎'
                                };
                            @endphp
                            <span class="text-4xl">{{ $icon }}</span>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-lg">{{ basename($material->file_path) }}</p>
                            <p class="text-xs text-gray-500">{{ strtoupper($material->file_type) }} file</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition shadow-md hover:scale-105 transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download File
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- YouTube Video Card (if exists) -->
        @if($material->youtube_url)
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-white px-6 py-5 border-b border-gray-100">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    YouTube Video
                </h3>
            </div>
            <div class="p-6 md:p-8">
                @php
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $material->youtube_url, $match);
                    $videoId = $match[1] ?? null;
                @endphp
                @if($videoId)
                    <div class="aspect-video rounded-2xl overflow-hidden shadow-xl">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Open on YouTube
                        </a>
                    </div>
                @else
                    <div class="bg-red-50 rounded-2xl p-8 text-center">
                        <p class="text-red-600 font-medium mb-2">Invalid YouTube URL</p>
                        <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 underline">Open link in new tab</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- No content warning (if neither file nor youtube) -->
        @if(!$material->file_path && !$material->youtube_url)
        <div class="bg-amber-50/80 backdrop-blur-sm rounded-3xl shadow-lg border border-amber-200 p-8 text-center">
            <svg class="w-16 h-16 text-amber-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-amber-700 font-medium">No content attached to this material.</p>
            <p class="text-amber-600 text-sm mt-1">Please edit and add a file or YouTube URL.</p>
        </div>
        @endif
    </div>
</x-app-layout>