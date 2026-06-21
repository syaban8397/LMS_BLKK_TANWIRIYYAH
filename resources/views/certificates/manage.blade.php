@php
    use App\Support\SecureStorage;
    $routePrefix = $routePrefix ?? 'admin.certificates';
    $downloadRoute = $downloadRoute ?? 'admin.certificates.download';
    $destroyRoute = $destroyRoute ?? $routePrefix . '.destroy';
@endphp

<x-app-layout>
    <x-lms-page-shell class="space-y-5">
        <x-lms-page-header
            :title="__('lms.certificate_page.class_title', ['title' => $class->title])"
            :subtitle="__('lms.certificate_page.instructor_subtitle', ['program' => $class->program->name, 'instructor' => $class->instructor->name])"
            :back-url="route($routePrefix . '.index')"
            :breadcrumbs="[
                ['label' => __('lms.nav.certificates'), 'url' => route($routePrefix . '.index')],
                ['label' => $class->title],
            ]"
        />

        <x-lms-panel>
            <div class="lms-info-panel">
                {!! __('lms.certificate_page.manage_hint', ['degree' => $class->program->certificate_degree_label]) !!}
            </div>
        </x-lms-panel>

        <form id="certificate-form" method="POST" action="{{ route($routePrefix . '.save-statuses', $class) }}">
            @csrf
        </form>

        <x-lms-section :title="__('lms.certificate_page.bulk_status_label')" icon="certificate" compact>
            <x-lms-panel>
                <div class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wide">{{ __('lms.certificate_page.bulk_status_label') }}</label>
                        <select id="bulk-status" class="input-3d min-w-[160px]">
                            <option value="">{{ __('lms.certificate_page.select_status') }}</option>
                            <option value="pass">{{ __('lms.certificate_page.pass') }}</option>
                            <option value="fail">{{ __('lms.certificate_page.fail') }}</option>
                        </select>
                    </div>
                    <button type="button" id="apply-bulk-status" class="lms-btn-secondary">
                        {{ __('lms.certificate_page.apply_selected') }}
                    </button>
                    <div class="flex-1"></div>
                    <button type="submit"
                            form="certificate-form"
                            id="confirm-save"
                            class="lms-btn-primary"
                            data-lms-confirm="{{ __('lms.certificate_page.confirm_save') }}">
                        {{ __('lms.certificate_page.confirm') }}
                    </button>
                    <button type="submit"
                            form="certificate-form"
                            formaction="{{ route($routePrefix . '.bulk-issue', $class) }}"
                            class="lms-btn-warning"
                            data-lms-confirm="{{ __('lms.certificate_page.issue_confirm') }}">
                        {{ __('lms.certificate_page.issue_selected') }}
                    </button>
                    <a href="{{ route($routePrefix . '.export', $class) }}" class="lms-btn-success">
                        {{ __('lms.export_excel') }}
                    </a>
                </div>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.certificate_page.participant')" icon="users">
            <x-lms-panel flush :pad="false">
                <x-lms-data-table>
                    <x-slot:head>
                        <tr>
                            <th class="px-4 py-3 text-center w-12">
                                <input type="checkbox" id="select-all" class="rounded border-slate-300 text-blue-600" title="{{ __('lms.certificate_page.select_all') }}">
                            </th>
                            <th class="px-4 py-3 text-left">{{ __('lms.certificate_page.participant') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.certificate_page.attendance_col') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.certificate_page.submission_col') }}</th>
                            <th class="px-4 py-3 text-center w-44">{{ __('lms.certificate_page.graduation_status') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.certificate_page.certificate_col') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.certificate_page.download_col') }}</th>
                            <th class="px-4 py-3 text-center w-28">{{ __('lms.certificate_page.action_col') }}</th>
                        </tr>
                    </x-slot:head>
                    @forelse($students as $row)
                        @php
                            $participant = $row['participant'];
                            $finalGrade = $row['final_grade'];
                            $certificate = $row['certificate'];
                            $status = $finalGrade?->status;
                            $pid = $participant->id;
                        @endphp
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox"
                                       form="certificate-form"
                                       name="selected[]"
                                       value="{{ $pid }}"
                                       class="row-select rounded border-slate-300 text-blue-600">
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $participant->name }}</div>
                                <div class="text-xs text-slate-500">{{ $participant->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="font-semibold text-blue-700">{{ $row['attendance_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_meetings'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="font-semibold text-purple-700">{{ $row['submission_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_assignments'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <select form="certificate-form"
                                        name="status[{{ $pid }}]"
                                        class="status-select input-3d text-sm py-1.5 w-full max-w-[140px] mx-auto"
                                        data-participant="{{ $pid }}">
                                    <option value="" {{ empty($status) ? 'selected' : '' }}>{{ __('lms.certificate_page.not_yet') }}</option>
                                    <option value="pass" {{ $status === 'pass' ? 'selected' : '' }}>{{ __('lms.certificate_page.pass') }}</option>
                                    <option value="fail" {{ $status === 'fail' ? 'selected' : '' }}>{{ __('lms.certificate_page.fail') }}</option>
                                </select>
                            </td>
                            <td class="px-4 py-3 text-center text-xs">
                                @if($certificate?->pdf_file && SecureStorage::exists($certificate->pdf_file))
                                    <x-ds.badge variant="success">{{ __('lms.certificate_page.issued_label') }}</x-ds.badge>
                                    <div class="text-slate-400 mt-1">{{ $certificate->issued_at?->format('d/m/Y') }}</div>
                                @elseif($certificate?->pdf_file)
                                    <x-ds.badge variant="warning">{{ __('lms.certificate_page.file_missing_label') }}</x-ds.badge>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($certificate?->pdf_file && SecureStorage::exists($certificate->pdf_file))
                                    <a href="{{ route($downloadRoute, $certificate) }}"
                                       class="lms-action-btn lms-action-btn--view">PDF</a>
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($certificate?->pdf_file && SecureStorage::exists($certificate->pdf_file))
                                    <form action="{{ route($destroyRoute, [$class, $certificate]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="lms-btn-danger text-xs px-2 py-1"
                                                data-lms-confirm="{{ __('lms.certificate_page.delete_confirm', ['name' => $participant->name]) }}">
                                            {{ __('lms.certificate_page.delete_btn') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-10 text-center text-slate-400">{{ __('lms.certificate_page.no_participants') }}</td></tr>
                    @endforelse
                </x-lms-data-table>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const rowSelects = document.querySelectorAll('.row-select');
            const bulkStatus = document.getElementById('bulk-status');
            const applyBulkBtn = document.getElementById('apply-bulk-status');

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    rowSelects.forEach(function (cb) {
                        cb.checked = selectAll.checked;
                    });
                });
            }

            rowSelects.forEach(function (cb) {
                cb.addEventListener('change', function () {
                    if (!selectAll) return;
                    const allChecked = Array.from(rowSelects).every(function (r) { return r.checked; });
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = !allChecked && Array.from(rowSelects).some(function (r) { return r.checked; });
                });
            });

            if (applyBulkBtn && bulkStatus) {
                applyBulkBtn.addEventListener('click', function () {
                    const value = bulkStatus.value;

                    if (!value) {
                        window.LmsDialog.alert(@json(__('lms.certificate_page.select_status_first')));
                        return;
                    }

                    const selected = Array.from(rowSelects).filter(function (cb) { return cb.checked; });

                    if (selected.length === 0) {
                        window.LmsDialog.alert(@json(__('lms.certificate_page.select_one_participant')));
                        return;
                    }

                    selected.forEach(function (cb) {
                        const row = cb.closest('tr');
                        const statusSelect = row?.querySelector('.status-select');
                        if (statusSelect) {
                            statusSelect.value = value;
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>
