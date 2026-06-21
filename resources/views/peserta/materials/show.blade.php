<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="$material->title"
            :subtitle="__('lms.material.meeting_subtitle', ['number' => $material->meeting_number, 'class' => $class->title])"
            :back-url="route('peserta.materials.index', $class)"
            :back-label="__('lms.material.back_materials')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.material.list'), 'url' => route('peserta.materials.index', $class)],
                ['label' => $material->title],
            ]"
        />

        <x-lms-panel :title="__('lms.material.info_title')" icon="document">
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">{{ __('lms.material.title') }}</p>
                    <p class="text-slate-800 font-semibold text-lg">{{ $material->title }}</p>
                </div>
                @if($material->description)
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide mb-1">{{ __('lms.common.description') }}</p>
                        <p class="text-slate-700 text-sm whitespace-pre-line">{{ $material->description }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">{{ __('lms.material.meeting') }}</p>
                        <p class="text-slate-800 font-medium text-sm">#{{ $material->meeting_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">{{ __('lms.material.instructor') }}</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $material->creator->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">{{ __('lms.material.uploaded_at') }}</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $material->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-lms-panel>

        @if($material->file_path)
        <x-lms-panel :title="__('lms.material.attachment_file')" icon="document">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                <div class="flex items-center gap-3">
                    <x-lms-file-icon type="{{ $material->file_type }}" class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center" />
                    <div>
                        <p class="font-semibold text-slate-800">{{ basename($material->file_path) }}</p>
                        <p class="text-xs text-slate-500">{{ __('lms.material.file_type_suffix', ['type' => strtoupper($material->file_type)]) }}</p>
                    </div>
                </div>
                <a href="{{ route('secure.materials.file', [$class, $material]) }}" target="_blank" class="lms-btn-primary inline-flex items-center gap-1">
                    <x-lms-icon name="upload" class="w-4 h-4" />
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
                <div class="aspect-video rounded-xl overflow-hidden shadow-sm">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ $material->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">
                        <x-lms-icon name="link" class="w-3 h-3" />
                        {{ __('lms.material.open_youtube') }}
                    </a>
                </div>
            @else
                <x-lms-notice tone="danger" :title="__('lms.material.invalid_youtube')">
                    <a href="{{ $material->youtube_url }}" target="_blank" class="text-blue-600 text-xs">{{ __('lms.material.open_link_new_tab') }}</a>
                </x-lms-notice>
            @endif
        </x-lms-panel>
        @endif

        <x-lms-panel class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">{{ __('lms.material.progress_title') }}</p>
                @if($progress->isCompleted())
                    <p class="text-green-700 font-semibold mt-1 inline-flex items-center gap-1">
                        <x-lms-icon name="check-circle" class="w-4 h-4" />
                        {{ __('lms.material.progress_completed') }}
                    </p>
                    @if($progress->completed_at)
                        <p class="text-xs text-slate-500 mt-1">{{ __('lms.material.completed_at', ['date' => $progress->completed_at->format('d M Y H:i')]) }}</p>
                    @endif
                @else
                    <p class="text-slate-700 font-medium mt-1">{{ __('lms.material.progress_not_started') }}</p>
                @endif
            </div>
            @unless($progress->isCompleted())
                <form action="{{ route('peserta.materials.complete', [$class, $material]) }}" method="POST">
                    @csrf
                    <button type="submit" class="lms-btn-success">{{ __('lms.material.mark_completed') }}</button>
                </form>
            @endunless
        </x-lms-panel>

        @if(!$material->file_path && !$material->youtube_url)
        <x-lms-panel>
            <x-lms-notice tone="warning" :title="__('lms.material.no_content_peserta')">
                {{ __('lms.material.no_content_peserta_hint') }}
            </x-lms-notice>
        </x-lms-panel>
        @endif
    </x-lms-page-shell>
</x-app-layout>
