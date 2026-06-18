<x-app-layout>
<div class="show-wrapper lms-module-shell max-w-5xl mx-auto space-y-6">
        <x-lms-page-header
            :title="$material->title"
            :subtitle="__('lms.material.show_subtitle', ['class' => $class->title])"
            :back-url="route('instruktur.materials.index', $class)"
            :back-label="__('lms.material.back_materials')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.material.library'), 'url' => route('instruktur.materials.index', $class)],
                ['label' => $material->title],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="lms-btn-warning">✏️ {{ __('lms.edit') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        {{-- 1. Material Information Card --}}
        <div class="detail-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('lms.material.detail') }}
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="info-row">
                        <p class="text-xs text-gray-500 font-semibold">{{ __('lms.material.title') }}</p>
                        <p class="text-gray-800 font-bold text-lg">{{ $material->title }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">{{ __('lms.material.meeting') }}</p>
                            <p class="text-gray-800 font-bold text-base">#{{ $material->meeting_number }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">{{ __('lms.material.created_by') }}</p>
                            <p class="text-gray-800">{{ $material->creator->name }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">{{ __('lms.common.created_at') }}</p>
                            <p class="text-gray-800 text-xs">{{ $material->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="info-row">
                            <p class="text-xs text-gray-500 font-semibold">{{ __('lms.common.updated_at_label') }}</p>
                            <p class="text-gray-800 text-xs">{{ $material->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                @if($material->description)
                    <div class="info-row pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-1">{{ __('lms.common.description') }}</p>
                        <div class="prose prose-sm max-w-none text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $material->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- 2. File Attachment Card (jika ada) --}}
        @if($material->file_path)
        <div class="detail-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6M9 21H4a1 1 0 01-1-1V4a1 1 0 011-1h10l6 6v11a1 1 0 01-1 1h-3M15 3v6h6"></path></svg>
                    {{ __('lms.common.attachment') }}
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
                    <a href="{{ route('secure.materials.file', [$class, $material]) }}" target="_blank" class="lms-action-btn lms-action-btn--view inline-flex items-center gap-1 !bg-emerald-600 hover:!bg-emerald-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        {{ __('lms.common.download') }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- 3. YouTube Video Card (jika ada) --}}
        @if($material->youtube_url)
        <div class="detail-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    {{ __('lms.material.youtube_video') }}
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
                        <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">{{ __('lms.material.open_youtube') }}</a>
                    </div>
                @else
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <p class="text-red-600 text-sm font-medium">{{ __('lms.material.invalid_youtube') }}</p>
                        <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 text-xs">{{ __('lms.material.open_link') }}</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- 4. No content warning (jika tidak ada file & youtube) --}}
        @if(!$material->file_path && !$material->youtube_url)
        <div class="detail-card bg-white rounded-lg shadow-md border border-slate-200 p-6 text-center">
            <svg class="w-12 h-12 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-amber-700 font-medium text-sm">{{ __('lms.material.no_content') }}</p>
            <p class="text-amber-600 text-xs mt-1">{{ __('lms.material.no_content_hint') }}</p>
        </div>
        @endif
    </div>
</x-app-layout>
