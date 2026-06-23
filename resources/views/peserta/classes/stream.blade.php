<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.common.subtitle_code_instructor', ['code' => $class->code, 'instructor' => $class->instructor->name])"
            :back-url="route('peserta.classes.show', $class)"
            :back-label="__('lms.common.class_detail')"
            :breadcrumbs="[
                ['label' => __('lms.nav.classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.common.class_stream')],
            ]"
        />

        <div class="lms-stream-layout">
            <div class="lms-stream-sidebar space-y-5">
                <x-lms-section :title="__('lms.common.class_info')" icon="clipboard" compact>
                    <x-lms-panel>
                        <div class="lms-detail-list">
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.report.program') }}</span><span class="lms-detail-row__value">{{ $class->program->name }}</span></div>
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.common.status') }}</span><span class="lms-detail-row__value"><x-lms-status-badge :status="$class->status" type="class" /></span></div>
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.common.period') }}</span><span class="lms-detail-row__value">{{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}</span></div>
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.common.description') }}</span><span class="lms-detail-row__value">{{ $class->description ?: __('lms.common.no_description') }}</span></div>
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.quick_links')" icon="bolt" compact>
                    <x-lms-panel>
                        <div class="lms-quick-grid">
                            <a href="{{ route('peserta.materials.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                                <span>{{ __('lms.common.all_materials') }}</span>
                            </a>
                            <a href="{{ route('peserta.assignments.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>
                                <span>{{ __('lms.common.all_assignments') }}</span>
                            </a>
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="calendar" /></span>
                                <span>{{ __('lms.common.my_attendance') }}</span>
                            </a>
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.statistics')" icon="chart" compact>
                    <x-lms-panel>
                        <div class="lms-detail-list">
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.common.announcements_label') }}</span><span class="lms-detail-row__value font-semibold tabular-nums">{{ $announcements->count() }}</span></div>
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.dashboard.materials') }}</span><span class="lms-detail-row__value font-semibold tabular-nums">{{ $materials->count() }}</span></div>
                            <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.dashboard.assignments') }}</span><span class="lms-detail-row__value font-semibold tabular-nums">{{ $assignments->count() }}</span></div>
                            @if(isset($attendances))
                                <div class="lms-detail-row"><span class="lms-detail-row__label">{{ __('lms.dashboard.attendance_sessions') }}</span><span class="lms-detail-row__value font-semibold tabular-nums">{{ $attendances->count() }}</span></div>
                            @endif
                        </div>
                    </x-lms-panel>
                </x-lms-section>
            </div>

            <div class="lms-stream-main space-y-5">
                <x-lms-section compact>
                    <x-lms-panel>
                        <div class="lms-quick-grid lms-quick-grid--3">
                            <a href="{{ route('peserta.materials.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                                <span>
                                    <span class="lms-quick-link__title">{{ __('lms.dashboard.materials') }}</span>
                                    <span class="lms-quick-link__desc">{{ __('lms.common.browse_resources') }}</span>
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
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.class_stream')" icon="megaphone" compact>
                    <div class="lms-timeline">
                        @forelse($announcements as $announcement)
                            <x-lms-panel class="lms-timeline-item lms-timeline-item--announcement">
                                <div class="flex items-start gap-3">
                                    <div class="lms-avatar-badge"><x-lms-icon name="megaphone" /></div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-slate-800">{{ $announcement->creator?->name ?? __('lms.common.system') }}</p>
                                        <p class="text-xs text-slate-400">{{ $announcement->created_at->diffForHumans() }}</p>
                                        <h4 class="font-bold text-slate-800 mt-2">{{ $announcement->title }}</h4>
                                        <p class="text-slate-600 text-sm mt-1 whitespace-pre-line">{{ $announcement->description }}</p>
                                    </div>
                                </div>
                            </x-lms-panel>
                        @empty
                            <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_announcements') }}</x-lms-panel>
                        @endforelse

                        @forelse($materials as $material)
                            <x-lms-panel class="lms-timeline-item lms-timeline-item--material">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex gap-3 min-w-0">
                                        <div class="lms-avatar-badge"><x-lms-icon name="book" /></div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-800">{{ $material->creator?->name ?? __('lms.common.instructor_fallback') }}</p>
                                            <p class="text-xs text-slate-400">{{ __('lms.common.meeting') }} {{ $material->meeting_number }} • {{ $material->created_at->diffForHumans() }}</p>
                                            <h4 class="font-bold text-slate-800 mt-2">{{ $material->title }}</h4>
                                            @if($material->description)<p class="text-slate-600 text-sm mt-1">{{ $material->description }}</p>@endif
                                        </div>
                                    </div>
                                    <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="lms-action-btn lms-action-btn--view shrink-0">{{ __('lms.view') }}</a>
                                </div>
                            </x-lms-panel>
                        @empty
                            <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_materials') }}</x-lms-panel>
                        @endforelse

                        @forelse($assignments as $assignment)
                            @php
                                $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                                if ($submission && $submission->isGraded()) {
                                    $statusBadge = __('lms.common.graded');
                                } elseif ($submission) {
                                    $statusBadge = __('lms.common.submitted');
                                } else {
                                    $statusBadge = __('lms.common.not_submitted');
                                }
                            @endphp
                            <x-lms-panel class="lms-timeline-item lms-timeline-item--assignment">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex gap-3 min-w-0">
                                        <div class="lms-avatar-badge"><x-lms-icon name="document" /></div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-800">{{ $assignment->creator?->name ?? __('lms.common.instructor_fallback') }}</p>
                                            <p class="text-xs text-slate-400">
                                                @if($assignment->deadline->isFuture())
                                                    {{ __('lms.common.due_label') }} {{ $assignment->deadline->format('d M Y H:i') }}
                                                @else
                                                    <span class="text-red-600 font-medium">{{ __('lms.common.ended_label') }} {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                                @endif
                                            </p>
                                            <h4 class="font-bold text-slate-800 mt-2">{{ $assignment->title }}</h4>
                                            <p class="text-slate-600 text-sm mt-1">{{ $assignment->description }}</p>
                                            @if($assignment->attachment)
                                                <a href="{{ route('secure.assignments.attachment', [$class, $assignment]) }}" target="_blank" class="text-xs text-brand-600 mt-2 inline-block hover:underline">{{ __('lms.common.download') }} {{ __('lms.common.attachment') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2 shrink-0">
                                        <span class="lms-badge {{ $submission && $submission->isGraded() ? 'lms-badge--success' : ($submission ? 'lms-badge--warning' : 'lms-badge--danger') }}">{{ $statusBadge }}</span>
                                        <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="lms-action-btn lms-action-btn--view">{{ __('lms.view') }}</a>
                                    </div>
                                </div>
                            </x-lms-panel>
                        @empty
                            <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_assignments') }}</x-lms-panel>
                        @endforelse

                        @if(isset($attendances) && $attendances->count() > 0)
                            <x-lms-panel class="lms-timeline-item lms-timeline-item--attendance">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex gap-3">
                                        <div class="lms-avatar-badge"><x-lms-icon name="calendar" /></div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ __('lms.common.attendance_summary') }}</p>
                                            <p class="text-xs text-slate-400">{{ __('lms.common.attendance_records') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('peserta.attendances.index', $class) }}" class="lms-action-btn lms-action-btn--approve shrink-0">{{ __('lms.common.view_all_btn') }}</a>
                                </div>
                                <div class="lms-attendance-mini-grid mt-4">
                                    <div class="lms-attendance-mini-stat bg-green-50/80"><p class="text-xl font-bold text-green-700 tabular-nums">{{ $attendances->where('status', 'present')->count() }}</p><p class="text-xs text-green-600">{{ __('lms.report.present') }}</p></div>
                                    <div class="lms-attendance-mini-stat bg-amber-50/80"><p class="text-xl font-bold text-amber-700 tabular-nums">{{ $attendances->where('status', 'permission')->count() }}</p><p class="text-xs text-amber-600">{{ __('lms.report.permission') }}</p></div>
                                    <div class="lms-attendance-mini-stat bg-orange-50/80"><p class="text-xl font-bold text-orange-700 tabular-nums">{{ $attendances->where('status', 'sick')->count() }}</p><p class="text-xs text-orange-600">{{ __('lms.report.sick') }}</p></div>
                                    <div class="lms-attendance-mini-stat bg-red-50/80"><p class="text-xl font-bold text-red-700 tabular-nums">{{ $attendances->where('status', 'absent')->count() }}</p><p class="text-xs text-red-600">{{ __('lms.report.absent') }}</p></div>
                                </div>
                                @php
                                    $totalMeetings = $attendances->count();
                                    $presentCount = $attendances->where('status', 'present')->count();
                                    $attRate = $totalMeetings > 0 ? round(($presentCount / $totalMeetings) * 100) : 0;
                                @endphp
                                <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/60">
                                    <x-lms-progress tone="success" :label="__('lms.dashboard.attendance_rate')" :value="$attRate" :max="100" :meta="$attRate.'%'" />
                                </div>
                            </x-lms-panel>
                        @endif
                    </div>
                </x-lms-section>
            </div>
        </div>
    </x-lms-page-shell>
</x-app-layout>
