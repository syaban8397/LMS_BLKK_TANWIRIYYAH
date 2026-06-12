<x-app-layout>
    <style>
        /* Animasi 3D */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .show-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Card utama */
        .detail-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .detail-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(1deg);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        /* Stagger untuk card (muncul bertahap) */
        .detail-card:nth-child(1) { animation-delay: 0.05s; } /* info */
        .detail-card:nth-child(2) { animation-delay: 0.15s; } /* file */
        .detail-card:nth-child(3) { animation-delay: 0.25s; } /* youtube */
        .detail-card:nth-child(4) { animation-delay: 0.35s; } /* warning */

        /* Animasi untuk konten di dalam card */
        .info-row {
            animation: fadeSlideUp 0.4s ease forwards;
            opacity: 0;
        }
        .info-row:nth-child(1) { animation-delay: 0.1s; }
        .info-row:nth-child(2) { animation-delay: 0.15s; }
        .info-row:nth-child(3) { animation-delay: 0.2s; }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 18px -6px rgba(0, 0, 0, 0.2);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* File preview hover */
        .file-preview {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .file-preview:hover {
            transform: translateY(-3px) scale(1.01);
            background-color: #f1f5f9;
            box-shadow: 0 8px 16px -6px rgba(0,0,0,0.1);
        }

        /* Video embed hover */
        .video-wrapper {
            transition: all 0.3s ease;
        }
        .video-wrapper:hover {
            transform: scale(1.01) rotateX(2deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="show-wrapper max-w-5xl mx-auto">
        {{-- Tombol aksi di kanan atas --}}
        <div class="flex justify-end gap-3 mb-6">
            <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit
            </a>
            <a href="{{ route('instruktur.materials.index', $class) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Materials
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- 1. Material Information Card --}}
        <div class="detail-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Material Details
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="info-row">
                        <p class="text-xs text-gray-500 font-semibold">Title</p>
                        <p class="text-gray-800 font-bold text-lg">{{ $material->title }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">Meeting</p>
                            <p class="text-gray-800 font-bold text-base">#{{ $material->meeting_number }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">Created By</p>
                            <p class="text-gray-800">{{ $material->creator->name }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">Created</p>
                            <p class="text-gray-800 text-xs">{{ $material->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">Updated</p>
                            <p class="text-gray-800 text-xs">{{ $material->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                @if($material->description)
                    <div class="info-row pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-1">Description</p>
                        <div class="prose prose-sm max-w-none text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $material->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- 2. File Attachment Card (jika ada) --}}
        @if($material->file_path)
        <div class="detail-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6M9 21H4a1 1 0 01-1-1V4a1 1 0 011-1h10l6 6v11a1 1 0 01-1 1h-3M15 3v6h6"></path></svg>
                    Attachment
                </h3>
            </div>
            <div class="p-4">
                <div class="file-preview flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 transition-all">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-2xl shadow-sm">
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
                            <span class="text-2xl">{{ $icon }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ basename($material->file_path) }}</p>
                            <p class="text-xs text-gray-500">{{ strtoupper($material->file_type) }}</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium transition shadow-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- 3. YouTube Video Card (jika ada) --}}
        @if($material->youtube_url)
        <div class="detail-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    YouTube Video
                </h3>
            </div>
            <div class="p-4">
                @php
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $material->youtube_url, $match);
                    $videoId = $match[1] ?? null;
                @endphp
                @if($videoId)
                    <div class="video-wrapper aspect-video rounded-xl overflow-hidden shadow-sm transition-all">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">Open on YouTube</a>
                    </div>
                @else
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <p class="text-red-600 text-sm font-medium">Invalid YouTube URL</p>
                        <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 text-xs">Open link</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- 4. No content warning (jika tidak ada file & youtube) --}}
        @if(!$material->file_path && !$material->youtube_url)
        <div class="detail-card bg-white rounded-2xl shadow-md border border-slate-200 p-6 text-center">
            <svg class="w-12 h-12 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-amber-700 font-medium text-sm">No content attached</p>
            <p class="text-amber-600 text-xs mt-1">Edit and add a file or YouTube URL.</p>
        </div>
        @endif
    </div>
</x-app-layout>