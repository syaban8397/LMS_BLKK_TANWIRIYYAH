<x-app-layout>
    <x-lms-page-shell class="show-program-wrapper space-y-5">
        <x-lms-page-header
            :title="$program->name"
            :subtitle="__('lms.common.program_summary')"
            :back-url="route('admin.programs.index')"
        >
            <x-slot:actions>
                <x-lms-status-badge :status="$program->status" type="program" />
                <a href="{{ route('admin.programs.edit', $program) }}" class="lms-btn-warning inline-flex items-center gap-1.5">
                    <x-lms-icon name="edit" class="w-4 h-4" />
                    {{ __('lms.edit') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-section :title="__('lms.dashboard.overview')" icon="chart" compact>
            <x-lms-panel flush :pad="false">
                <x-lms-stat-grid class="md:grid-cols-3">
                    <x-lms-stat-card
                        :label="__('lms.common.total_classes')"
                        :value="$program->classes()->count()"
                        icon="building"
                        tone="blue"
                    />
                    <x-lms-stat-card
                        :label="__('lms.common.created_at')"
                        :value="$program->created_at->format('d M Y')"
                        icon="calendar"
                        tone="green"
                    />
                    <x-lms-stat-card
                        :label="__('lms.common.updated_at_label')"
                        :value="$program->updated_at->format('d M Y')"
                        icon="clock"
                        tone="indigo"
                    />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.admin_page.program_info')" icon="clipboard">
            <x-lms-panel>
                <div class="lms-detail-grid md:grid-cols-2">
                    <div class="lms-detail-list">
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.program_name') }}</span>
                            <span class="lms-detail-row__value">{{ $program->name }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.active_class_flag') }}</span>
                            <span class="lms-detail-row__value">
                                <x-lms-status-badge :status="$program->status" type="program" />
                            </span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.certificate_title') }}</span>
                            <span class="lms-detail-row__value">{{ $program->certificate_degree_label }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.certificate_validity') }}</span>
                            <span class="lms-detail-row__value">{{ $program->validity_years ?? config('certificate.default_validity_years') }} {{ __('lms.admin_page.years_suffix') }}</span>
                        </div>
                    </div>
                    <div class="lms-detail-list">
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.start_date') }}</span>
                            <span class="lms-detail-row__value">{{ $program->start_date->format('d M Y') }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.end_date') }}</span>
                            <span class="lms-detail-row__value">{{ $program->end_date->format('d M Y') }}</span>
                        </div>
                        <div class="lms-detail-row">
                            <span class="lms-detail-row__label">{{ __('lms.common.class_capacity') }}</span>
                            <span class="lms-detail-row__value">{{ $program->classCount() }}/{{ $program->capacity }} {{ __('lms.admin_page.classes_suffix') }}</span>
                        </div>
                    </div>
                </div>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.admin_page.program_desc')" icon="document">
            <x-lms-panel>
                <p class="text-sm text-slate-600 whitespace-pre-line">{{ $program->description ?: __('lms.common.no_description') }}</p>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.common.actions')" icon="bolt" compact>
            <x-lms-panel>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.programs.edit', $program) }}" class="lms-btn-warning">
                        {{ __('lms.admin_page.edit_program_btn') }}
                    </a>
                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" data-lms-confirm="{{ __('lms.common.delete_program') }}" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="lms-btn-danger">
                            {{ __('lms.admin_page.delete_program_btn') }}
                        </button>
                    </form>
                    <a href="{{ route('admin.programs.index') }}" class="lms-btn-secondary">
                        {{ __('lms.common.back_to_programs') }}
                    </a>
                </div>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
