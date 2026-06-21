@props([
    'title',
    'meta' => null,
    'paginator' => null,
    'emptyIcon' => 'inbox',
    'emptyTitle' => null,
    'emptyDescription' => null,
])

<x-lms-card :title="$title" :meta="$meta" {{ $attributes->merge(['class' => 'lms-list-card p-0 overflow-hidden']) }}>
    @if($paginator && $paginator->count() > 0)
        <div class="lms-list-card__body">{{ $slot }}</div>
        <x-lms-pagination :paginator="$paginator" />
    @else
        <x-lms-empty-state
            :icon="$emptyIcon"
            :title="$emptyTitle ?? __('lms.no_data')"
            :description="$emptyDescription"
            class="border-0 shadow-none !py-10"
        >
            @isset($emptyActions)
                {{ $emptyActions }}
            @endisset
        </x-lms-empty-state>
    @endif
</x-lms-card>
