@props([
    'colspan',
    'message' => null,
    'icon' => '📭',
    'description' => null,
])

<tr>
    <td colspan="{{ $colspan }}" class="lms-data-table__empty">
        <x-lms-empty-state
            :icon="$icon"
            :title="$message ?? __('lms.no_data')"
            :description="$description"
            class="border-0 shadow-none !py-8 bg-transparent"
        >
            @isset($actions)
                <div class="mt-3">{{ $actions }}</div>
            @endisset
        </x-lms-empty-state>
    </td>
</tr>
