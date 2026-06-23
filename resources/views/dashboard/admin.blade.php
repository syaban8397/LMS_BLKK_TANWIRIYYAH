<x-app-layout>

    <x-lms-page-shell>

        <x-lms-page-header

            :title="__('lms.dashboard.admin_title')"

            :subtitle="__('lms.dashboard.admin_subtitle', ['name' => auth()->user()->name])"

        />



        <div class="lms-dashboard-page">

            <div class="lms-dashboard-page__stats">

                <x-lms-stat-card :label="__('lms.dashboard.total_participants')" :value="$participants ?? 0" icon="users" tone="blue" :animate="true" :hint="($pendingParticipants ?? 0) > 0 ? $pendingParticipants.' '.__('lms.dashboard.pending_approval') : __('lms.dashboard.stat_active')" />

                <x-lms-stat-card :label="__('lms.dashboard.active_instructors')" :value="$instructors ?? 0" icon="academic-cap" tone="indigo" :animate="true" :hint="__('lms.dashboard.stat_active')" />

                <x-lms-stat-card :label="__('lms.dashboard.running_classes')" :value="$classes ?? 0" icon="building" tone="green" :animate="true" :hint="__('lms.dashboard.stat_active')" />

                <x-lms-stat-card :label="__('lms.dashboard.certificates_issued')" :value="$certificates ?? 0" icon="certificate" tone="amber" :animate="true" :hint="__('lms.dashboard.stat_updated_today')" />

                <x-lms-stat-card :label="__('lms.dashboard.materials')" :value="$materials ?? 0" icon="book" tone="blue" :animate="true" />

                <x-lms-stat-card :label="__('lms.dashboard.assignments')" :value="$assignments ?? 0" icon="document" tone="indigo" :animate="true" />

                <x-lms-stat-card :label="__('lms.dashboard.attendance_sessions')" :value="$attendanceSessions ?? 0" icon="calendar" tone="green" :animate="true" />

                <x-lms-stat-card :label="__('lms.dashboard.announcements')" :value="$announcements ?? 0" icon="megaphone" tone="amber" :animate="true" />

            </div>



            <div class="lms-dashboard-page__row lms-dashboard-page__row--2-1">

                <x-lms-section :title="__('lms.dashboard.recent_activity')" icon="clipboard" compact>

                    <x-slot:headerActions>

                        <span id="lastUpdate" class="lms-badge lms-badge--info text-[10px]">{{ __('lms.loading') }}...</span>

                    </x-slot:headerActions>

                    <x-lms-panel>

                        <table class="lms-mini-table">

                            <thead>

                                <tr>

                                    <th>{{ __('lms.common.description') }}</th>

                                    <th class="text-right">{{ __('lms.common.total') }}</th>

                                    <th>{{ __('lms.dashboard.status_col') }}</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr><td>{{ __('lms.dashboard.materials') }}</td><td class="text-right font-semibold tabular-nums">{{ $materials ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--info">{{ __('lms.dashboard.stat_active') }}</span></td></tr>

                                <tr><td>{{ __('lms.dashboard.assignments') }}</td><td class="text-right font-semibold tabular-nums">{{ $assignments ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--info">{{ __('lms.dashboard.stat_active') }}</span></td></tr>

                                <tr><td>{{ __('lms.dashboard.attendance_sessions') }}</td><td class="text-right font-semibold tabular-nums">{{ $attendanceSessions ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--success">{{ __('lms.dashboard.stat_updated_today') }}</span></td></tr>

                                <tr><td>{{ __('lms.dashboard.total_attendance') }}</td><td class="text-right font-semibold tabular-nums">{{ $attendances ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--neutral">{{ __('lms.dashboard.stat_active') }}</span></td></tr>

                                <tr><td>{{ __('lms.dashboard.grades_processed') }}</td><td class="text-right font-semibold tabular-nums">{{ $grades ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--success">{{ __('lms.dashboard.stat_active') }}</span></td></tr>

                                <tr><td>{{ __('lms.dashboard.announcements') }}</td><td class="text-right font-semibold tabular-nums">{{ $announcements ?? 0 }}</td><td><span class="lms-status-pill lms-status-pill--neutral">{{ __('lms.dashboard.stat_active') }}</span></td></tr>

                            </tbody>

                        </table>

                        <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/60">

                            <div class="flex justify-between text-xs mb-1.5">

                                <span class="text-slate-500">{{ __('lms.dashboard.avg_attendance') }}</span>

                                <span class="font-semibold tabular-nums">{{ $avgAttendance ?? 0 }}%</span>

                            </div>

                            <div class="lms-progress-track">

                                <div class="lms-progress-fill" style="width: {{ min($avgAttendance ?? 0, 100) }}%"></div>

                            </div>

                        </div>

                    </x-lms-panel>

                </x-lms-section>



                <x-lms-section :title="__('lms.dashboard.program_distribution')" icon="programs" compact>

                    <x-slot:headerActions>

                        <x-lms-section-link :href="route('admin.programs.index')">{{ __('lms.dashboard.view_programs') }} →</x-lms-section-link>

                    </x-slot:headerActions>

                    <x-lms-panel>

                        @forelse($programDistribution ?? [] as $program)

                            <div class="lms-schedule-card">

                                <div class="flex items-start justify-between gap-2">

                                    <span class="lms-schedule-card__tag">{{ __('lms.report.program') }}</span>

                                    <span class="text-[10px] font-semibold text-emerald-600">{{ __('lms.dashboard.stat_active') }}</span>

                                </div>

                                <p class="lms-schedule-card__title">{{ $program['name'] }}</p>

                                <p class="lms-schedule-card__meta">{{ $program['count'] }} {{ __('lms.dashboard.students') }}</p>

                                <div class="lms-progress-track mt-2">

                                    <div class="lms-progress-fill" style="width: {{ ($program['count'] / max($maxProgramCount, 1)) * 100 }}%"></div>

                                </div>

                            </div>

                        @empty

                            <x-lms-empty-state icon="inbox" :title="__('lms.no_data')" class="border-0 shadow-none !py-6" />

                        @endforelse

                    </x-lms-panel>

                </x-lms-section>

            </div>



            <div class="lms-dashboard-page__row lms-dashboard-page__row--1-1">

                <x-lms-section :title="__('lms.dashboard.recent_submissions')" icon="document" compact>

                    <x-slot:headerActions>

                        <x-lms-section-link :href="route('admin.reports.grades')">{{ __('lms.dashboard.view_reports') }} →</x-lms-section-link>

                    </x-slot:headerActions>

                    <x-lms-panel>

                        @if(($recentSubmissions ?? collect())->isNotEmpty())

                            <div class="lms-feed-list">

                                @foreach($recentSubmissions as $submission)

                                    <x-lms-feed-item

                                        icon="document"

                                        tone="blue"

                                        :title="$submission->participant?->name ?? '—'"

                                        :subtitle="$submission->assignment?->title ?? '—'"

                                        :meta="$submission->submitted_at?->diffForHumans() ?? '—'"

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

                        <x-lms-section-link :href="route('admin.certificates.index')">{{ __('lms.dashboard.view_certificates') }} →</x-lms-section-link>

                    </x-slot:headerActions>

                    <x-lms-panel>

                        @if(($recentCertificates ?? collect())->isNotEmpty())

                            <div class="lms-feed-list">

                                @foreach($recentCertificates as $certificate)

                                    <x-lms-feed-item

                                        icon="certificate"

                                        tone="indigo"

                                        :title="$certificate->participant?->name ?? '—'"

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

                    if (el.firstChild && el.firstChild.nodeType === Node.TEXT_NODE) {

                        el.firstChild.textContent = start;

                    } else {

                        el.textContent = start;

                    }

                }, 20);

            });

            setInterval(() => {

                const el = document.getElementById('lastUpdate');

                if (el) el.innerText = "{{ __('lms.dashboard.updated_at') }}: " + new Date().toLocaleTimeString('{{ app()->getLocale() === 'id' ? 'id-ID' : 'en-US' }}');

            }, 1000);

        });

    </script>

</x-app-layout>

