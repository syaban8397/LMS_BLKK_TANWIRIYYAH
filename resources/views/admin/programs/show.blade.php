<x-app-layout>
<div class="show-program-wrapper lms-page-shell space-y-5">
        <x-lms-page-header
            :title="$program->name"
            :subtitle="__('lms.common.program_summary')"
            :back-url="route('admin.programs.index')"
        >
            <x-slot:actions>
                @if($program->status == 'active')
                    <span class="lms-badge lms-badge--success">{{ __('lms.active') }}</span>
                @else
                    <span class="lms-badge">{{ __('lms.inactive') }}</span>
                @endif
                <a href="{{ route('admin.programs.edit', $program) }}" class="lms-btn-warning">✏️ {{ __('lms.edit') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.total_classes') }}</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $program->classes()->count() }}</p>
                    </div>
                    <div class="text-xl">🏫</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.created_at') }}</p>
                        <p class="text-sm font-semibold text-green-700 mt-1">{{ $program->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">📅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.updated_at_label') }}</p>
                        <p class="text-sm font-semibold text-purple-600 mt-1">{{ $program->updated_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">🔄</div>
                </div>
            </div>
        </div>

        {{-- Program Information --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span>📋</span> {{ __('lms.admin_page.program_info') }}
            </h3>
            <div class="grid md:grid-cols-2 gap-x-5 gap-y-4 text-sm">
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.program_name') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.active_class_flag') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->status === 'active' ? __('lms.active') : __('lms.admin_page.inactive_label') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.certificate_title') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->certificate_degree_label }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.certificate_validity') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->validity_years ?? config('certificate.default_validity_years') }} {{ __('lms.admin_page.years_suffix') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.start_date') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->start_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.end_date') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->end_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.class_capacity') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->classCount() }}/{{ $program->capacity }} {{ __('lms.admin_page.classes_suffix') }}</p>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-2 flex items-center gap-2">
                <span>📝</span> {{ __('lms.admin_page.program_desc') }}
            </h3>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $program->description ?: __('lms.common.no_description') }}</p>
        </div>

        {{-- Action Buttons --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.programs.edit', $program) }}" 
                   class="lms-btn-warning">
                    {{ __('lms.admin_page.edit_program_btn') }}
                </a>
                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" data-lms-confirm="{{ __('lms.common.delete_program') }}" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="lms-btn-danger">
                        {{ __('lms.admin_page.delete_program_btn') }}
                    </button>
                </form>
                <a href="{{ route('admin.programs.index') }}" 
                   class="lms-btn-secondary">
                    {{ __('lms.common.back_to_programs') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
