<x-app-layout>

    <x-lms-page-shell>

        <x-lms-page-header

            :title="__('lms.dashboard.instruktur_title')"

            :subtitle="__('lms.dashboard.instruktur_subtitle', ['name' => auth()->user()->name])"

            :badge="__('lms.dashboard.instruktur_panel')"

        />



        <div class="lms-dashboard-page">

            <div class="lms-dashboard-page__stats">

                <x-lms-stat-card :label="__('lms.dashboard.my_classes')" :value="$classes ?? 0" icon="building" tone="blue" :animate="true" :hint="__('lms.dashboard.my_classes_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.materials')" :value="$materials ?? 0" icon="book" tone="green" :animate="true" :hint="__('lms.dashboard.materials_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.assignments')" :value="$assignments ?? 0" icon="document" tone="amber" :animate="true" :hint="__('lms.dashboard.assignments_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.students')" :value="$participants ?? 0" icon="graduation-cap" tone="indigo" :animate="true" :hint="__('lms.dashboard.students_enrolled')" />

                <x-lms-stat-card :label="__('lms.dashboard.active_classes')" :value="$activeClasses ?? 0" icon="check-circle" tone="green" :animate="true" :hint="__('lms.dashboard.active_classes_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.pending_grading')" :value="$pendingGrades ?? 0" icon="clock" tone="amber" :animate="true" :hint="__('lms.dashboard.pending_grading_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.attendance_sessions')" :value="$attendanceSessions ?? 0" icon="calendar" tone="blue" :animate="true" :hint="__('lms.dashboard.attendance_sessions_hint')" />

                <x-lms-stat-card :label="__('lms.dashboard.announcements')" :value="$announcements ?? 0" icon="megaphone" tone="indigo" :animate="true" :hint="__('lms.dashboard.announcements_hint')" />

            </div>



            <div class="lms-dashboard-page__row lms-dashboard-page__row--2-1">

                @if(isset($recentClasses) && count($recentClasses) > 0)

                <x-lms-section :title="__('lms.dashboard.recent_classes')" icon="clipboard" compact>

                    <x-slot:headerActions>

                        <x-lms-section-link :href="route('instruktur.classes.index')">{{ __('lms.dashboard.view_all') }}</x-lms-section-link>

                    </x-slot:headerActions>

                    <x-lms-panel>

                        <table class="lms-mini-table">

                            <thead>

                                <tr>

                                    <th>{{ __('lms.common.class_title') }}</th>

                                    <th>{{ __('lms.common.code') }}</th>

                                    <th class="text-right">{{ __('lms.dashboard.students') }}</th>

                                    <th>{{ __('lms.dashboard.status_col') }}</th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($recentClasses as $class)

                                    <tr>

                                        <td class="font-medium">{{ $class->title }}</td>

                                        <td class="text-slate-500">{{ $class->code }}</td>

                                        <td class="text-right tabular-nums">{{ $class->participants_count }}/{{ $class->quota }}</td>

                                        <td><span class="lms-status-pill lms-status-pill--{{ $class->status === 'active' ? 'success' : 'neutral' }}">{{ ucfirst($class->status) }}</span></td>

                                        <td class="text-right">

                                            <x-lms-action-btn variant="view" :href="route('instruktur.classes.stream', $class)">{{ __('lms.dashboard.view_class') }}</x-lms-action-btn>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </x-lms-panel>

                </x-lms-section>

                @else

                <x-lms-section :title="__('lms.dashboard.recent_classes')" icon="clipboard" compact>

                    <x-lms-panel>

                        <x-lms-empty-state icon="building" :title="__('lms.common.no_classes_assigned')" class="border-0 shadow-none !py-6" />

                    </x-lms-panel>

                </x-lms-section>

                @endif



                <x-lms-section :title="__('lms.dashboard.quick_access')" icon="bolt" compact>

                    <x-lms-panel>

                        <div class="lms-quick-grid">

                            <a href="{{ route('instruktur.classes.index') }}" class="lms-quick-link">

                                <span class="lms-quick-link__icon"><x-lms-icon name="building" /></span>

                                <span>{{ __('lms.dashboard.my_classes') }}</span>

                            </a>

                            <a href="{{ route('instruktur.classes.index') }}" class="lms-quick-link">

                                <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>

                                <span>{{ __('lms.dashboard.materials') }}</span>

                            </a>

                            <a href="{{ route('instruktur.classes.index') }}" class="lms-quick-link">

                                <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>

                                <span>{{ __('lms.dashboard.assignments') }}</span>

                            </a>

                            <a href="{{ route('instruktur.classes.index') }}" class="lms-quick-link">

                                <span class="lms-quick-link__icon"><x-lms-icon name="calendar" /></span>

                                <span>{{ __('lms.dashboard.attendance_sessions') }}</span>

                            </a>

                        </div>

                    </x-lms-panel>

                </x-lms-section>

            </div>



            <div class="lms-dashboard-page__row lms-dashboard-page__row--1-1">

                <x-lms-section :title="__('lms.dashboard.pending_grading')" icon="clock" compact>

                    <x-lms-panel>

                        @if(($pendingSubmissionList ?? collect())->isNotEmpty())

                            <div class="lms-feed-list">

                                @foreach($pendingSubmissionList as $submission)

                                    @php $class = $submission->assignment?->class; @endphp

                                    <x-lms-feed-item

                                        icon="document"

                                        tone="amber"

                                        :title="$submission->participant?->name ?? '—'"

                                        :subtitle="$submission->assignment?->title ?? '—'"

                                        :meta="$submission->submitted_at?->diffForHumans() ?? '—'"
                                        :meta-accent="__('lms.dashboard.grade_now').' →'"
                                        :href="$class && $submission->assignment ? route('instruktur.grades.show', [$class, $submission->assignment, $submission]) : null"
                                    />

                                @endforeach

                            </div>

                        @else

                            <x-lms-empty-state icon="check-circle" :title="__('lms.dashboard.pending_grading_hint')" class="border-0 shadow-none !py-6" />

                        @endif

                    </x-lms-panel>

                </x-lms-section>



                <x-lms-section :title="__('lms.dashboard.recent_submissions')" icon="document" compact>

                    <x-lms-panel>

                        @if(($recentSubmissions ?? collect())->isNotEmpty())

                            <div class="lms-feed-list">

                                @foreach($recentSubmissions as $submission)

                                    <x-lms-feed-item

                                        icon="document"

                                        tone="blue"

                                        :title="$submission->participant?->name ?? '—'"

                                        :subtitle="$submission->assignment?->title ?? '—'"

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

