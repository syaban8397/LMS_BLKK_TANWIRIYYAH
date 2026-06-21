<x-app-layout>
    <x-lms-page-shell>
    <x-lms-page-header
            :title="__('lms.certificate_page.my_class_cert')"
            :subtitle="__('lms.certificate_page.instructor_manage_desc')"
            :back-url="route('instruktur.dashboard')"
            :breadcrumbs="[
                ['label' => __('lms.nav.certificates')],
            ]"
        />

        <x-lms-session-flash />

        <x-lms-data-table :paginator="$classes" :skeleton-cols="4">
            <x-slot:head>
                <tr>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.admin_page.class_label') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.admin_page.program_label') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.certificate_page.issued') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                </tr>
            </x-slot:head>

            @forelse($classes as $class)
                <tr class="transition">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $class->title }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $class->code }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600 dark:text-slate-300">{{ $class->program->name }}</td>
                    <td class="px-4 py-3 text-center font-bold text-orange-600 dark:text-orange-400">{{ $class->certificates_count }}</td>
                    <td class="px-4 py-3 text-center">
                        <x-lms-row-actions>
                            <x-lms-action-btn variant="view" :href="route('instruktur.certificates.show', $class)">{{ __('lms.admin_page.manage_btn') }}</x-lms-action-btn>
                        </x-lms-row-actions>
                    </td>
                </tr>
            @empty
                <x-lms-table-empty :colspan="4" :message="__('lms.certificate_page.no_classes_assigned')" />
            @endforelse
        </x-lms-data-table>
    </x-lms-page-shell>
</x-app-layout>
