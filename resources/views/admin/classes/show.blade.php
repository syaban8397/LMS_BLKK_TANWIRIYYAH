<x-app-layout>
    <x-lms-page-shell class="space-y-5">
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.admin_page.class_code_subtitle', ['code' => $class->code])"
            :back-url="route('admin.classes.index')"
            :breadcrumbs="[
                ['label' => __('lms.nav.classes'), 'url' => route('admin.classes.index')],
                ['label' => $class->title],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.certificates.show', $class) }}" class="lms-btn-warning">{{ __('lms.admin_page.certificates_btn') }}</a>
                <a href="{{ route('admin.announcements.show', $class) }}" class="lms-btn-primary">{{ __('lms.admin_page.announcements_btn') }}</a>
                <a href="{{ route('admin.classes.edit', $class) }}" class="lms-btn-secondary inline-flex items-center gap-1.5">
                    <x-lms-icon name="edit" class="w-4 h-4" />
                    {{ __('lms.edit') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-section :title="__('lms.common.class_information')" icon="clipboard">
            <x-lms-panel>
                <div class="lms-detail-grid md:grid-cols-2">
                    <div class="lms-detail-list">
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.report.program') }}</span>
                            <span class="lms-detail-row__value">{{ $class->program->name }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.report.instructor') }}</span>
                            <span class="lms-detail-row__value">{{ $class->instructor->name }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.class_code') }}</span>
                            <span class="lms-detail-row__value">{{ $class->code }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.student_quota') }}</span>
                            <span class="lms-detail-row__value">{{ $class->quota }}</span>
                        </div>
                    </div>
                    <div class="lms-detail-list">
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.start_date') }}</span>
                            <span class="lms-detail-row__value">{{ $class->start_date->format('d M Y') }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.end_date') }}</span>
                            <span class="lms-detail-row__value">{{ $class->end_date->format('d M Y') }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.status') }}</span>
                            <span class="lms-detail-row__value">
                                <x-lms-status-badge :status="$class->status" type="class" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100">
                    <div class="lms-detail-row border-b-0 pb-0">
                        <span class="lms-detail-row__label">{{ __('lms.common.description') }}</span>
                        <span class="lms-detail-row__value">{{ $class->description ?: __('lms.common.no_description') }}</span>
                    </div>
                </div>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.common.enrolled_students_count', ['current' => $class->participants->count(), 'quota' => $class->quota])" icon="graduation-cap">
            <x-lms-panel flush :pad="false">
                <x-lms-data-table>
                    <x-slot:head>
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('lms.common.name') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('lms.auth.email') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.enrolled_at') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.status') }}</th>
                        </tr>
                    </x-slot:head>
                    @forelse($class->participants as $participant)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $participant->participant->name }}</td>
                            <td class="px-4 py-3 text-slate-600 text-xs">{{ $participant->participant->email }}</td>
                            <td class="px-4 py-3 text-center text-slate-600 text-xs">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @switch($participant->status)
                                    @case('active')
                                        <x-lms-status-badge status="active" type="class" />
                                        @break
                                    @case('completed')
                                        <x-lms-status-badge status="completed" type="class" />
                                        @break
                                    @case('dropped')
                                        <x-ds.badge variant="danger">{{ __('lms.common.dropped') }}</x-ds.badge>
                                        @break
                                    @default
                                        <x-lms-status-badge :status="$participant->status" type="class" />
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-sm">{{ __('lms.common.no_students') }}</td>
                        </tr>
                    @endforelse
                </x-lms-data-table>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
