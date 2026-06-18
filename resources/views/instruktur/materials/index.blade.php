<x-app-layout>
    <div class="materials-wrapper lms-module-shell max-w-7xl mx-auto">
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

        <x-lms-session-flash />

        <x-lms-list-card
            class="materials-card"
            :title="__('lms.material.list')"
            :meta="__('lms.material.total_meta', ['total' => $materials->total()])"
            :paginator="$materials"
            emptyIcon="📚"
            :emptyTitle="__('lms.material.empty_title')"
            :emptyDescription="__('lms.material.empty_desc')"
        >
            <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                @foreach($materials as $material)
                    <div class="material-row p-5 transition group">
                        <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="lms-badge lms-badge--info">{{ __('lms.material.meeting') }} {{ $material->meeting_number }}</span>
                                    @if($material->file_path)
                                        <span class="lms-badge lms-badge--success">📎 {{ strtoupper($material->file_type) }}</span>
                                    @endif
                                    @if($material->youtube_url)
                                        <span class="lms-badge lms-badge--danger">🎥 {{ __('lms.material.youtube') }}</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $material->title }}</h4>
                                @if($material->description)
                                    <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-2">{{ $material->description }}</p>
                                @endif
                                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">{{ __('lms.material.uploaded_ago', ['time' => $material->created_at->diffForHumans()]) }}</p>
                            </div>
                            <x-lms-row-actions class="flex-shrink-0">
                                <x-lms-action-btn variant="view" :href="route('instruktur.materials.show', [$class, $material])">{{ __('lms.view') }}</x-lms-action-btn>
                                <x-lms-action-btn variant="edit" :href="route('instruktur.materials.edit', [$class, $material])">{{ __('lms.edit') }}</x-lms-action-btn>
                                <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.material.delete_confirm')">{{ __('lms.delete') }}</x-lms-action-btn>
                                </form>
                            </x-lms-row-actions>
                        </div>
                    </div>
                @endforeach
            </div>

            <x-slot:emptyActions>
                <a href="{{ route('instruktur.materials.create', $class) }}" class="lms-btn-primary mt-2">{{ __('lms.material.create_btn') }}</a>
            </x-slot:emptyActions>
        </x-lms-list-card>
    </div>
</x-app-layout>
