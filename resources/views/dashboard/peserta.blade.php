<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.dashboard.peserta_title')"
            :subtitle="__('lms.dashboard.peserta_subtitle', ['name' => auth()->user()->name])"
            :badge="__('lms.dashboard.peserta_panel')"
        />

        <div class="lms-dashboard-page">
            <div class="lms-dashboard-page__stats">
                <x-lms-stat-card :label="__('lms.dashboard.my_classes')" :value="$classes ?? 0" icon="building" tone="blue" :animate="true" :hint="__('lms.dashboard.my_classes_enrolled')" />
                <x-lms-stat-card :label="__('lms.dashboard.materials')" :value="$materials ?? 0" icon="book" tone="green" :animate="true" :hint="__('lms.dashboard.materials_available')" />
                <x-lms-stat-card :label="__('lms.dashboard.assignments')" :value="$assignments ?? 0" icon="document" tone="amber" :animate="true" :hint="__('lms.dashboard.assignments_total')" />
                <x-lms-stat-card :label="__('lms.nav.certificates')" :value="$certificates ?? 0" icon="certificate" tone="indigo" :animate="true" :hint="__('lms.dashboard.earned_certificates')" />
                <x-lms-stat-card :label="__('lms.dashboard.completed_classes')" :value="$completedClasses ?? 0" icon="check-circle" tone="green" :animate="true" :hint="__('lms.dashboard.completed_classes_hint')" />
                <x-lms-stat-card :label="__('lms.dashboard.pending_assignments')" :value="$pendingAssignments ?? 0" icon="clock" tone="amber" :animate="true" :hint="__('lms.dashboard.pending_assignments_hint')" />
                <x-lms-stat-card :label="__('lms.material.progress_title')" :value="$materialProgressPercentage ?? 0" icon="book" tone="indigo" :animate="true" suffix="%" />
                <x-lms-stat-card :label="__('lms.dashboard.attendance_rate')" :value="$attendancePercentage ?? 0" icon="calendar" tone="blue" :animate="true" suffix="%" :hint="__('lms.dashboard.attendance_rate_hint')" />
            </div>

            <div class="lms-dashboard-page__row lms-dashboard-page__row--2-1">
                <x-lms-section :title="__('lms.dashboard.latest_announcements')" icon="megaphone" compact>
                    <x-slot:headerActions>
                        <x-lms-section-link :href="route('peserta.classes.index')">{{ __('lms.dashboard.view_classes') }}</x-lms-section-link>
                    </x-slot:headerActions>
                    <x-lms-panel>
                        @if(isset($announcements) && $announcements->count() > 0)
                            @foreach($announcements as $announcement)
                                <div class="lms-schedule-card">
                                    <div class="flex items-start justify-between gap-2">
                                        <span class="lms-schedule-card__tag">{{ $announcement->class->title ?? __('lms.dashboard.class_fallback') }}</span>
                                        <span class="text-[10px] font-semibold text-emerald-600">{{ __('lms.dashboard.stat_active') }}</span>
                                    </div>
                                    <p class="lms-schedule-card__title">{{ $announcement->title }}</p>
                                    <p class="lms-schedule-card__meta">{{ $announcement->created_at->diffForHumans() }}</p>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ Str::limit($announcement->description, 100) }}</p>
                                    @if($announcement->class)
                                        <x-lms-section-link :href="route('peserta.classes.stream', $announcement->class)" class="inline-block mt-2">{{ __('lms.dashboard.read') }} →</x-lms-section-link>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <x-lms-empty-state icon="megaphone" :title="__('lms.common.no_announcements_yet')" class="border-0 shadow-none !py-6" />
                        @endif
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.dashboard.quick_access')" icon="bolt" compact>
                    <x-lms-panel>
                        <div class="lms-quick-grid">
                            <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="building" /></span>
                                <span>{{ __('lms.dashboard.my_classes') }}</span>
                            </a>
                            @if($primaryClass)
                                <a href="{{ route('peserta.materials.index', $primaryClass) }}" class="lms-quick-link">
                                    <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                                    <span>{{ __('lms.dashboard.materials') }}</span>
                                </a>
                                <a href="{{ route('peserta.assignments.index', $primaryClass) }}" class="lms-quick-link">
                                    <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>
                                    <span>{{ __('lms.dashboard.assignments') }}</span>
                                </a>
                            @else
                                <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link lms-quick-link--muted" title="{{ __('lms.dashboard.enroll_first_hint') }}">
                                    <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                                    <span>{{ __('lms.dashboard.materials') }}</span>
                                </a>
                                <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link lms-quick-link--muted" title="{{ __('lms.dashboard.enroll_first_hint') }}">
                                    <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>
                                    <span>{{ __('lms.dashboard.assignments') }}</span>
                                </a>
                            @endif
                            <a href="{{ route('peserta.certificates.index') }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="certificate" /></span>
                                <span>{{ __('lms.nav.certificates') }}</span>
                            </a>
                        </div>
                    </x-lms-panel>
                </x-lms-section>
            </div>

            <div class="lms-dashboard-page__row lms-dashboard-page__row--1-1">
                <x-lms-section :title="__('lms.dashboard.recent_submissions')" icon="document" compact>
                    <x-lms-panel>
                        @if(($recentSubmissions ?? collect())->isNotEmpty())
                            <div class="lms-feed-list">
                                @foreach($recentSubmissions as $submission)
                                    <x-lms-feed-item
                                        icon="document"
                                        tone="blue"
                                        :title="Str::limit($submission->assignment?->title ?? '—', 36)"
                                        :subtitle="$submission->assignment?->class?->title ?? '—'"
                                        :meta="ucfirst($submission->status)"
                                        :meta-accent="$submission->score ? __('lms.dashboard.score_label', ['score' => $submission->score]) : null"
                                    />
                                @endforeach
                            </div>
                        @else
                            <x-lms-empty-state icon="inbox" :title="__('lms.submission.no_submissions')" class="border-0 shadow-none !py-6" />
                        @endif
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.dashboard.recent_certificates')" icon="certificate" compact>
                    <x-slot:headerActions>
                        <x-lms-section-link :href="route('peserta.certificates.index')">{{ __('lms.dashboard.view_certificates') }} →</x-lms-section-link>
                    </x-slot:headerActions>
                    <x-lms-panel>
                        @if(($recentCertificates ?? collect())->isNotEmpty())
                            <div class="lms-feed-list">
                                @foreach($recentCertificates as $certificate)
                                    <x-lms-feed-item
                                        icon="certificate"
                                        tone="indigo"
                                        :title="$certificate->class?->title ?? __('lms.dashboard.class_fallback')"
                                        :subtitle="$certificate->certificate_number"
                                        :meta="$certificate->issued_at?->format('d M Y') ?? '—'"
                                    />
                                @endforeach
                            </div>
                        @else
                            <x-lms-empty-state icon="certificate" :title="__('lms.report.no_certificates')" class="border-0 shadow-none !py-6" />
                        @endif
                    </x-lms-panel>
                </x-lms-section>
            </div>
        </div>
    </x-lms-page-shell>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.counter').forEach(el => {
                const end = parseInt(el.dataset.value) || 0;
                let start = 0;
                const step = Math.max(1, Math.ceil(end / 40));
                const interval = setInterval(() => {
                    start += step;
                    if (start >= end) { start = end; clearInterval(interval); }
                    el.firstChild.textContent = start;
                }, 20);
            });
        });
    </script>
</x-app-layout>
