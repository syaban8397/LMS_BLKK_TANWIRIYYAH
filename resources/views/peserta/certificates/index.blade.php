<x-app-layout>
    <x-lms-page-shell>
    <x-lms-page-header
            :title="__('lms.certificate_page.my_cert')"
            :subtitle="__('lms.certificate_page.my_list_desc')"
            :back-url="route('peserta.dashboard')"
            :breadcrumbs="[
                ['label' => __('lms.certificate_page.my_cert')],
            ]"
        />

        <x-lms-data-table :paginator="$certificates" :skeleton-cols="5">
            <x-slot:head>
                <tr>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.certificate_page.class_program') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.certificate_page.cert_number') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.certificate_page.issued_at') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.certificate_page.attendance_pct') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                </tr>
            </x-slot:head>

            @forelse($certificates as $certificate)
                <tr class="transition">
                    <td class="px-4 py-3">
                        <div class="font-medium text-slate-800 dark:text-slate-100">{{ $certificate->class->title }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $certificate->class->program->name }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs font-mono text-slate-600 dark:text-slate-300">{{ $certificate->certificate_number }}</td>
                    <td class="px-4 py-3 text-center text-slate-600 dark:text-slate-300">{{ $certificate->issued_at?->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-center text-blue-700 dark:text-blue-400 font-medium">{{ $certificate->attendance_percentage }}%</td>
                    <td class="px-4 py-3 text-center">
                        <x-lms-row-actions>
                            <x-lms-action-btn variant="view" :href="route('peserta.certificates.download', $certificate)">{{ __('lms.certificate_page.print_download_btn') }}</x-lms-action-btn>
                        </x-lms-row-actions>
                    </td>
                </tr>
            @empty
                <x-lms-table-empty :colspan="5" :message="__('lms.certificate_page.no_certs_hint')" />
            @endforelse
        </x-lms-data-table>
    </x-lms-page-shell>
</x-app-layout>
