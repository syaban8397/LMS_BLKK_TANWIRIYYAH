<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.common.subtitle_code_instructor_dot', ['code' => $class->code, 'instructor' => $class->instructor->name])"
            :back-url="route('peserta.classes.index')"
            :back-label="__('lms.back')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('peserta.classes.stream', $class) }}" class="lms-btn-primary inline-flex items-center gap-1">
                    <x-lms-icon name="megaphone" class="w-4 h-4" />
                    {{ __('lms.common.class_stream') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-section :title="__('lms.common.class_information')" icon="clipboard" compact>
            <x-lms-panel>
                <div class="grid md:grid-cols-2">
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.report.program') }}</p><p class="text-slate-800 font-semibold">{{ $class->program->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.report.instructor') }}</p><p class="text-slate-800 font-semibold">{{ $class->instructor->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.enrollment_status') }}</p>
                            <span class="lms-badge
                                @switch($participation->status)
                                    @case('active') lms-badge--success @break
                                    @case('completed') lms-badge--info @break
                                    @case('dropped') lms-badge--danger @break
                                    @default
                                @endswitch">
                                @switch($participation->status)
                                    @case('active') {{ __('lms.active') }} @break
                                    @case('completed') {{ __('lms.common.completed') }} @break
                                    @case('dropped') {{ __('lms.common.dropped') }} @break
                                    @default {{ $participation->status }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.start_date') }}</p><p class="text-slate-800 font-semibold">{{ $class->start_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.end_date') }}</p><p class="text-slate-800 font-semibold">{{ $class->end_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.enrolled_at') }}</p><p class="text-slate-800 font-semibold">{{ $participation->enrolled_at?->format('d F Y') ?? '-' }}</p></div>
                    </div>
                </div>
                @if($class->description)
                <div class="mt-5 pt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold uppercase mb-2">{{ __('lms.common.description') }}</p>
                    <p class="text-slate-700 text-sm">{{ $class->description }}</p>
                </div>
                @endif
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.common.quick_links')" icon="bolt" compact>
            <x-lms-panel>
                <div class="lms-quick-grid">
                    <a href="{{ route('peserta.materials.index', $class) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                        <span>
                            <span class="lms-quick-link__title">{{ __('lms.dashboard.materials') }}</span>
                            <span class="lms-quick-link__desc">{{ __('lms.common.view_resources') }}</span>
                        </span>
                    </a>
                    <a href="{{ route('peserta.assignments.index', $class) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>
                        <span>
                            <span class="lms-quick-link__title">{{ __('lms.dashboard.assignments') }}</span>
                            <span class="lms-quick-link__desc">{{ __('lms.common.submit_tasks') }}</span>
                        </span>
                    </a>
                    <a href="{{ route('peserta.attendances.index', $class) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon"><x-lms-icon name="calendar" /></span>
                        <span>
                            <span class="lms-quick-link__title">{{ __('lms.common.attendance') }}</span>
                            <span class="lms-quick-link__desc">{{ __('lms.common.record_presence') }}</span>
                        </span>
                    </a>
                    <a href="{{ route('peserta.assignments.index', $class) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon"><x-lms-icon name="target" /></span>
                        <span>
                            <span class="lms-quick-link__title">{{ __('lms.common.my_grades') }}</span>
                            <span class="lms-quick-link__desc">{{ __('lms.common.check_progress') }}</span>
                        </span>
                    </a>
                </div>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.common.latest_from_instructor')" icon="megaphone" compact>
            <x-slot:headerActions>
                <span class="text-xs text-slate-400">{{ __('lms.common.instructor_updates') }}</span>
            </x-slot:headerActions>
            <x-lms-panel>
                @if(isset($announcements) && $announcements->count() > 0)
                    <div class="space-y-4">
                        @foreach($announcements->take(3) as $announcement)
                        <div class="lms-list-item">
                            <div class="min-w-0 flex-1">
                                <p class="lms-list-item__title">{{ $announcement->title }}</p>
                                <p class="lms-list-item__meta">{{ $announcement->created_at->diffForHumans() }}</p>
                                <p class="lms-list-item__body">{{ Str::limit($announcement->description, 120) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($announcements->count() > 3)
                    <div class="mt-4 text-right">
                        <a href="{{ route('peserta.classes.stream', $class) }}" class="text-xs text-blue-600 hover:underline">{{ __('lms.common.view_all_announcements') }}</a>
                    </div>
                    @endif
                @else
                    <x-lms-empty-state icon="megaphone" :title="__('lms.common.no_announcements_yet')" class="border-0 shadow-none !py-6" />
                @endif
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
