<x-app-layout>
    <x-lms-page-shell class="max-w-7xl mx-auto">
        <x-lms-page-header
            :title="__('lms.material.library')"
            :subtitle="$class->title"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.assignment.back_stream')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.material.library')],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.materials.create', $class) }}" class="lms-btn-primary">{{ __('lms.common.add_material') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if($materials->count() > 0)
        <x-lms-section :title="__('lms.material.list')" :description="__('lms.material.total_meta', ['total' => $materials->total()])" icon="book" compact>
            <x-lms-panel>
                @foreach($materials as $material)
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
                            </div>
                            <h4 class="lms-list-item__title">{{ $material->title }}</h4>
                            @if($material->description)
                                <p class="lms-list-item__body">{{ $material->description }}</p>
                            @endif
                            <p class="lms-list-item__meta">{{ __('lms.material.uploaded_ago', ['time' => $material->created_at->diffForHumans()]) }}</p>
                        </div>
                        <x-lms-row-actions class="shrink-0">
                            <x-lms-action-btn variant="view" :href="route('instruktur.materials.show', [$class, $material])">{{ __('lms.view') }}</x-lms-action-btn>
                            <x-lms-action-btn variant="edit" :href="route('instruktur.materials.edit', [$class, $material])">{{ __('lms.edit') }}</x-lms-action-btn>
                            <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.material.delete_confirm')">{{ __('lms.delete') }}</x-lms-action-btn>
                            </form>
                        </x-lms-row-actions>
                    </div>
                @endforeach
            </x-lms-panel>
            <x-lms-pagination :paginator="$materials" />
        </x-lms-section>
        @else
        <x-lms-section :title="__('lms.material.list')" compact>
            <x-lms-panel>
                <x-lms-empty-state icon="book" :title="__('lms.material.empty_title')" :description="__('lms.material.empty_desc')">
                    <x-slot:actions>
                        <a href="{{ route('instruktur.materials.create', $class) }}" class="lms-btn-primary mt-2">{{ __('lms.material.create_btn') }}</a>
                    </x-slot:actions>
                </x-lms-empty-state>
            </x-lms-panel>
        </x-lms-section>
        @endif
    </x-lms-page-shell>
</x-app-layout>
