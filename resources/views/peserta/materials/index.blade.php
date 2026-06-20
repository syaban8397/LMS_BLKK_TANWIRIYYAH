<x-app-layout>
    <div class="peserta-materials-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="$class->title . ' - ' . __('lms.material.list')"
            :subtitle="__('lms.material.peserta_index_subtitle')"
            :back-url="route('peserta.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.material.list')],
            ]"
        />

        <x-lms-session-flash />

        <x-lms-list-card
            class="materials-card"
            :title="__('lms.material.list_with_count', ['count' => $materials->total()])"
            :meta="__('lms.material.learning_resources')"
            :paginator="$materials"
            emptyIcon="book"
            :emptyTitle="__('lms.material.no_materials_available')"
        >
            <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                @foreach($materials as $material)
                    <div class="material-row p-5 transition group">
                        <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="lms-badge lms-badge--info">{{ __('lms.material.meeting') }} {{ $material->meeting_number }}</span>
                                    @if($material->file_path)
                                        <span class="lms-badge lms-badge--success">📎 {{ strtoupper($material->file_type) }}</span>
                                    @endif
                                    @if($material->youtube_url)
                                        <span class="lms-badge lms-badge--danger">🎥 {{ __('lms.material.youtube') }}</span>
                                    @endif
                                    @php $progressStatus = $progressMap[$material->id] ?? null; @endphp
                                    @if($progressStatus === 'completed')
                                        <span class="lms-badge lms-badge--success">✅ {{ __('lms.material.progress_completed') }}</span>
                                    @else
                                        <span class="lms-badge">{{ __('lms.material.progress_not_started') }}</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $material->title }}</h4>
                                @if($material->description)
                                    <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-2">{{ $material->description }}</p>
                                @endif
                                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">{{ __('lms.material.by') }} {{ $material->creator->name }} • {{ $material->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="lms-btn-primary px-4 py-2 text-sm">{{ __('lms.view') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-lms-list-card>
    </div>
</x-app-layout>
