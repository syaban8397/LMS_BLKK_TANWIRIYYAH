<x-app-layout>
    <x-lms-page-shell>
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

        @if($materials->count() > 0)
        <x-lms-section :title="__('lms.material.list_with_count', ['count' => $materials->total()])" :description="__('lms.material.learning_resources')" icon="book" compact>
            <x-lms-panel>
                @foreach($materials as $material)
                    @php $progressStatus = $progressMap[$material->id] ?? null; @endphp
                    <div class="lms-list-item">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="lms-badge lms-badge--info">{{ __('lms.material.meeting') }} {{ $material->meeting_number }}</span>
                                @if($material->file_path)
                                    <span class="lms-badge lms-badge--success inline-flex items-center gap-1">
                                        <x-lms-icon name="document" class="w-3 h-3" />
                                        {{ strtoupper($material->file_type) }}
                                    </span>
                                @endif
                                @if($material->youtube_url)
                                    <span class="lms-badge lms-badge--danger inline-flex items-center gap-1">
                                        <x-lms-icon name="link" class="w-3 h-3" />
                                        {{ __('lms.material.youtube') }}
                                    </span>
                                @endif
                                @if($progressStatus === 'completed')
                                    <span class="lms-badge lms-badge--success inline-flex items-center gap-1">
                                        <x-lms-icon name="check-circle" class="w-3 h-3" />
                                        {{ __('lms.material.progress_completed') }}
                                    </span>
                                @else
                                    <span class="lms-badge">{{ __('lms.material.progress_not_started') }}</span>
                                @endif
                            </div>
                            <h4 class="lms-list-item__title">{{ $material->title }}</h4>
                            @if($material->description)
                                <p class="lms-list-item__body">{{ $material->description }}</p>
                            @endif
                            <p class="lms-list-item__meta">{{ __('lms.material.by') }} {{ $material->creator->name }} · {{ $material->created_at->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="lms-btn-primary text-sm shrink-0">{{ __('lms.view') }}</a>
                    </div>
                @endforeach
            </x-lms-panel>
            <x-lms-pagination :paginator="$materials" />
        </x-lms-section>
        @else
        <x-lms-section :title="__('lms.material.list')" compact>
            <x-lms-panel>
                <x-lms-empty-state icon="book" :title="__('lms.material.no_materials_available')" />
            </x-lms-panel>
        </x-lms-section>
        @endif
    </x-lms-page-shell>
</x-app-layout>
