<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.dashboard.admin_title')"
            :subtitle="__('lms.dashboard.admin_subtitle', ['name' => auth()->user()->name])"
        />

        <x-lms-section :title="__('lms.dashboard.overview')" icon="chart" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--4">
                    <x-lms-stat-card
                        :label="__('lms.dashboard.total_participants')"
                        :value="$participants ?? 0"
                        icon="users"
                        tone="blue"
                        :animate="true"
                        :hint="($pendingParticipants ?? 0) > 0 ? $pendingParticipants.' '.__('lms.dashboard.pending_approval') : null"
                    />
                    <x-lms-stat-card
                        :label="__('lms.dashboard.active_instructors')"
                        :value="$instructors ?? 0"
                        icon="academic-cap"
                        tone="indigo"
                        :animate="true"
                    />
                    <x-lms-stat-card
                        :label="__('lms.dashboard.running_classes')"
                        :value="$classes ?? 0"
                        icon="building"
                        tone="green"
                        :animate="true"
                    />
                    <x-lms-stat-card
                        :label="__('lms.dashboard.certificates_issued')"
                        :value="$certificates ?? 0"
                        icon="certificate"
                        tone="amber"
                        :animate="true"
                    />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        <div class="lms-dashboard-grid lms-dashboard-grid--2-1">
            <x-lms-section :title="__('lms.dashboard.recent_activity')" icon="clipboard" compact>
                <x-lms-panel>
                    <x-slot:headerActions>
                        <span id="lastUpdate" class="lms-badge lms-badge--info text-[10px]">{{ __('lms.loading') }}...</span>
                    </x-slot:headerActions>
                    <div class="lms-activity-list">
                        <div class="lms-activity-row"><span class="text-slate-600">{{ __('lms.dashboard.materials') }}</span><span class="font-semibold tabular-nums">{{ $materials ?? 0 }}</span></div>
                        <div class="lms-activity-row"><span class="text-slate-600">{{ __('lms.dashboard.assignments') }}</span><span class="font-semibold tabular-nums">{{ $assignments ?? 0 }}</span></div>
                        <div class="lms-activity-row"><span class="text-slate-600">{{ __('lms.dashboard.attendance_sessions') }}</span><span class="font-semibold tabular-nums">{{ $attendanceSessions ?? 0 }}</span></div>
                        <div class="lms-activity-row"><span class="text-slate-600">{{ __('lms.dashboard.total_attendance') }}</span><span class="font-semibold tabular-nums">{{ $attendances ?? 0 }}</span></div>
                        <div class="lms-activity-row"><span class="text-slate-600">{{ __('lms.dashboard.grades_processed') }}</span><span class="font-semibold tabular-nums">{{ $grades ?? 0 }}</span></div>
                        <div class="lms-activity-row"><a href="{{ route('admin.announcements.index') }}" class="text-slate-600 hover:text-brand-600 transition">{{ __('lms.dashboard.announcements') }}</a><span class="font-semibold tabular-nums">{{ $announcements ?? 0 }}</span></div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-700/60">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-500">{{ __('lms.dashboard.avg_attendance') }}</span>
                            <span class="font-semibold tabular-nums text-slate-700 dark:text-slate-200">{{ $avgAttendance ?? 0 }}%</span>
                        </div>
                        <div class="lms-progress-track">
                            <div class="lms-progress-fill" style="width: {{ min($avgAttendance ?? 0, 100) }}%"></div>
                        </div>
                    </div>
                </x-lms-panel>
            </x-lms-section>

            <x-lms-section :title="__('lms.dashboard.program_distribution')" icon="programs" compact>
                <x-slot:headerActions>
                    <a href="{{ route('admin.programs.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition">{{ __('lms.dashboard.view_programs') }} →</a>
                </x-slot:headerActions>
                <x-lms-panel>
                    @forelse($programDistribution ?? [] as $program)
                        <div class="mb-4 last:mb-0">
                            <div class="flex justify-between text-sm mb-1.5 gap-2">
                                <span class="text-slate-600 truncate">{{ $program['name'] }}</span>
                                <span class="font-semibold tabular-nums shrink-0">{{ $program['count'] }}</span>
                            </div>
                            <div class="lms-progress-track">
                                <div class="lms-progress-fill" style="width: {{ ($program['count'] / max($maxProgramCount, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <x-lms-empty-state icon="inbox" :title="__('lms.no_data')" class="border-0 shadow-none !py-6" />
                    @endforelse
                </x-lms-panel>
            </x-lms-section>
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
