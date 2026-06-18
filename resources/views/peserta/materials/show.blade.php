<x-app-layout>
<div class="peserta-material-show-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$material->title"
            :subtitle="'Pertemuan ' . $material->meeting_number . ' — ' . $class->title"
            :back-url="route('peserta.materials.index', $class)"
            back-label="← Kembali ke Materi"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        {{-- Material Info Card --}}
        <div class="info-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Material Information
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Title</p>
                    <p class="text-slate-800 font-semibold text-lg">{{ $material->title }}</p>
                </div>
                @if($material->description)
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide mb-1">Description</p>
                        <p class="text-slate-700 text-sm whitespace-pre-line">{{ $material->description }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Meeting</p>
                        <p class="text-slate-800 font-medium text-sm">#{{ $material->meeting_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Instructor</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $material->creator->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Uploaded At</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $material->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- File Attachment Card --}}
        @if($material->file_path)
        <div class="file-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6M9 21H4a1 1 0 01-1-1V4a1 1 0 011-1h10l6 6v11a1 1 0 01-1 1h-3M15 3v6h6"></path></svg>
                    Attachment File
                </h3>
            </div>
            <div class="p-5">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-3xl shadow-sm">
                            @php
                                $icon = match(strtolower($material->file_type)) {
                                    'pdf' => '📄',
                                    'doc','docx' => '📝',
                                    'xls','xlsx' => '📊',
                                    'ppt','pptx' => '🎯',
                                    'zip','rar' => '📦',
                                    'jpg','jpeg','png','gif' => '🖼️',
                                    'mp4','mov','avi' => '🎬',
                                    default => '📎'
                                };
                            @endphp
                            <span class="text-3xl">{{ $icon }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">{{ basename($material->file_path) }}</p>
                            <p class="text-xs text-slate-500">{{ strtoupper($material->file_type) }} file</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- YouTube Video Card --}}
        @if($material->youtube_url)
        <div class="video-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    YouTube Video
                </h3>
            </div>
            <div class="p-5">
                @php
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $material->youtube_url, $match);
                    $videoId = $match[1] ?? null;
                @endphp
                @if($videoId)
                    <div class="aspect-video rounded-xl overflow-hidden shadow-sm">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Open on YouTube
                        </a>
                    </div>
                @else
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <p class="text-red-600 text-sm font-medium">Invalid YouTube URL</p>
                        <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 text-xs">Open link in new tab</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- No content warning --}}
        @if(!$material->file_path && !$material->youtube_url)
        <div class="warning-card bg-white rounded-xl shadow-md border border-slate-200 p-6 text-center">
            <svg class="w-10 h-10 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-amber-700 font-medium text-sm">No content attached to this material.</p>
            <p class="text-amber-600 text-xs mt-1">The instructor hasn't added any file or YouTube link.</p>
        </div>
        @endif
    </div>
</x-app-layout>