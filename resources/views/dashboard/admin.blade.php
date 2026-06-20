<x-app-layout>
    <div class="dashboard-wrapper lms-page-shell space-y-8">
        <x-lms-page-header
            :title="__('lms.dashboard.admin_title')"
            :subtitle="__('lms.dashboard.admin_subtitle', ['name' => auth()->user()->name])"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="dashboard-card p-5">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.total_participants') }}</p>
                <h3 class="text-2xl font-semibold text-slate-900 mt-1 counter" data-value="{{ $participants ?? 0 }}">0</h3>
                @if(($pendingParticipants ?? 0) > 0)
                    <p class="text-xs text-amber-600 mt-2">{{ $pendingParticipants }} {{ __('lms.dashboard.pending_approval') }}</p>
                @endif
            </div>
            <div class="dashboard-card p-5">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.active_instructors') }}</p>
                <h3 class="text-2xl font-semibold text-slate-900 mt-1 counter" data-value="{{ $instructors ?? 0 }}">0</h3>
            </div>
            <div class="dashboard-card p-5">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.running_classes') }}</p>
                <h3 class="text-2xl font-semibold text-slate-900 mt-1 counter" data-value="{{ $classes ?? 0 }}">0</h3>
            </div>
            <div class="dashboard-card p-5">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.certificates_issued') }}</p>
                <h3 class="text-2xl font-semibold text-slate-900 mt-1 counter" data-value="{{ $certificates ?? 0 }}">0</h3>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-4">
            <div class="analytics-card p-5 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-slate-900 text-sm flex items-center gap-2">
                        <x-lms-icon name="chart" class="w-4 h-4 text-indigo-600" />
                        {{ __('lms.dashboard.recent_activity') }}
                    </h3>
                    <span id="lastUpdate" class="text-[11px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">{{ __('lms.loading') }}...</span>
                </div>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-100 pb-2"><span class="text-slate-600">{{ __('lms.dashboard.materials') }}</span><span class="font-semibold">{{ $materials ?? 0 }}</span></div>
                    <div class="flex justify-between border-b border-slate-100 pb-2"><span class="text-slate-600">{{ __('lms.dashboard.assignments') }}</span><span class="font-semibold">{{ $assignments ?? 0 }}</span></div>
                    <div class="flex justify-between border-b border-slate-100 pb-2"><span class="text-slate-600">{{ __('lms.dashboard.attendance_sessions') }}</span><span class="font-semibold">{{ $attendanceSessions ?? 0 }}</span></div>
                    <div class="flex justify-between border-b border-slate-100 pb-2"><span class="text-slate-600">{{ __('lms.dashboard.total_attendance') }}</span><span class="font-semibold">{{ $attendances ?? 0 }}</span></div>
                    <div class="flex justify-between border-b border-slate-100 pb-2"><span class="text-slate-600">{{ __('lms.dashboard.grades_processed') }}</span><span class="font-semibold">{{ $grades ?? 0 }}</span></div>
                    <div class="flex justify-between"><a href="{{ route('admin.announcements.index') }}" class="text-slate-600 hover:text-blue-600">{{ __('lms.dashboard.announcements') }}</a><span class="font-semibold">{{ $announcements ?? 0 }}</span></div>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">{{ __('lms.dashboard.avg_attendance') }}</span>
                        <span class="font-medium text-slate-700">{{ $avgAttendance ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mt-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min($avgAttendance ?? 0, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <div class="analytics-card p-5">
                <h3 class="font-semibold text-slate-900 text-sm mb-4 flex items-center gap-2">
                    <x-lms-icon name="clipboard" class="w-4 h-4 text-indigo-600" />
                    {{ __('lms.dashboard.program_distribution') }}
                </h3>
                @forelse($programDistribution ?? [] as $program)
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600 truncate pr-2">{{ $program['name'] }}</span>
                            <span class="font-medium shrink-0">{{ $program['count'] }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($program['count'] / max($maxProgramCount, 1)) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">{{ __('lms.no_data') }}</p>
                @endforelse
                <div class="mt-4 text-right">
                    <a href="{{ route('admin.programs.index') }}" class="text-sm text-blue-600 hover:underline">{{ __('lms.dashboard.view_programs') }} →</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.counter').forEach(el => {
                const end = parseInt(el.dataset.value) || 0;
                let start = 0;
                const step = Math.max(1, Math.ceil(end / 40));
                const interval = setInterval(() => {
                    start += step;
                    if (start >= end) { start = end; clearInterval(interval); }
                    el.innerText = start;
                }, 20);
            });
            setInterval(() => {
                const el = document.getElementById('lastUpdate');
                if (el) el.innerText = "{{ __('lms.dashboard.updated_at') }}: " + new Date().toLocaleTimeString('{{ app()->getLocale() === 'id' ? 'id-ID' : 'en-US' }}');
            }, 1000);
        });
    </script>
</x-app-layout>
