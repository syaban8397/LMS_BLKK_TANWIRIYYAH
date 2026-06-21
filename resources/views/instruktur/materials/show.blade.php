<x-app-layout>
    <x-lms-page-shell class="max-w-5xl mx-auto">
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
                <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="lms-btn-warning inline-flex items-center gap-1">
                    <x-lms-icon name="edit" class="w-4 h-4" />
                    {{ __('lms.edit') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-panel :title="__('lms.material.detail')" icon="document">
            <div class="space-y-4">
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
        </x-lms-panel>

        @if($material->file_path)
        <x-lms-panel :title="__('lms.common.attachment')" icon="document">
            <div class="file-preview flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 transition-all">
                <div class="flex items-center gap-2">
                    <x-lms-file-icon type="{{ $material->file_type }}" class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center" />
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ basename($material->file_path) }}</p>
                        <p class="text-xs text-gray-500">{{ strtoupper($material->file_type) }}</p>
                    </div>
                </div>
                <a href="{{ route('secure.materials.file', [$class, $material]) }}" target="_blank" class="lms-action-btn lms-action-btn--view inline-flex items-center gap-1 !bg-emerald-600 hover:!bg-emerald-700">
                    <x-lms-icon name="upload" class="w-3 h-3" />
                    {{ __('lms.common.download') }}
                </a>
            </div>
        </x-lms-panel>
        @endif

        @if($material->youtube_url)
        <x-lms-panel :title="__('lms.material.youtube_video')" icon="link">
            @php
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $material->youtube_url, $match);
                $videoId = $match[1] ?? null;
            @endphp
            @if($videoId)
                <div class="video-wrapper aspect-video rounded-xl overflow-hidden shadow-sm transition-all">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">
                        <x-lms-icon name="link" class="w-3 h-3" />
                        {{ __('lms.material.open_youtube') }}
                    </a>
                </div>
            @else
                <x-lms-notice tone="danger" :title="__('lms.material.invalid_youtube')">
                    <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 text-xs">{{ __('lms.material.open_link') }}</a>
                </x-lms-notice>
            @endif
        </x-lms-panel>
        @endif

        @if(!$material->file_path && !$material->youtube_url)
        <x-lms-empty-state icon="inbox" :title="__('lms.material.no_content')" :description="__('lms.material.no_content_hint')" />
        @endif
    </x-lms-page-shell>
</x-app-layout>
