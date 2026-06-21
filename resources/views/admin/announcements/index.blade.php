<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header :title="__('lms.admin_page.class_announcements')" :subtitle="__('lms.admin_page.manage_announcements')" />

        <x-lms-section :title="__('lms.common.class_list')" icon="megaphone" compact>
            <x-lms-panel flush>
                <x-lms-data-table :paginator="$classes" :skeleton-cols="6">
                    <x-slot:head>
                        <tr>
                            <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.admin_page.class_label') }}</th>
                            <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.admin_page.program_label') }}</th>
                            <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.admin_page.instructor_label') }}</th>
                            <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                            <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.admin_page.announcement_count') }}</th>
                            <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                        </tr>
                    </x-slot:head>

                    @forelse($classes as $class)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $class->title }}</div>
                                <div class="text-xs text-slate-500">{{ $class->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->program->name }}</td>
                            <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->instructor->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <x-lms-status-badge :status="$class->status" type="class" />
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                    {{ $class->announcements_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-lms-row-actions>
                                    <x-lms-action-btn variant="view" :href="route('admin.announcements.show', $class)">{{ __('lms.admin_page.manage_btn') }}</x-lms-action-btn>
                                </x-lms-row-actions>
                            </td>
                        </tr>
                    @empty
                        <x-lms-table-empty :colspan="6" :message="__('lms.admin_page.no_classes_create_first')" />
                    @endforelse
                </x-lms-data-table>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
