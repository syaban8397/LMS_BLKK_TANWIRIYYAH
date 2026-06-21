<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.dashboard.instruktur_title')"
            :subtitle="__('lms.dashboard.instruktur_subtitle', ['name' => auth()->user()->name])"
            :badge="__('lms.dashboard.instruktur_panel')"
        />

        <x-lms-section :title="__('lms.dashboard.overview')" icon="chart" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--4">
                    <x-lms-stat-card :label="__('lms.dashboard.my_classes')" :value="$classes ?? 0" icon="building" tone="blue" :animate="true" :hint="__('lms.dashboard.my_classes_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.materials')" :value="$materials ?? 0" icon="book" tone="green" :animate="true" :hint="__('lms.dashboard.materials_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.assignments')" :value="$assignments ?? 0" icon="document" tone="amber" :animate="true" :hint="__('lms.dashboard.assignments_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.students')" :value="$participants ?? 0" icon="graduation-cap" tone="indigo" :animate="true" :hint="__('lms.dashboard.students_enrolled')" />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.dashboard.progress')" icon="clipboard" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--4">
                    <x-lms-stat-card :label="__('lms.dashboard.active_classes')" :value="$activeClasses ?? 0" icon="check-circle" tone="green" :animate="true" :hint="__('lms.dashboard.active_classes_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.pending_grading')" :value="$pendingGrades ?? 0" icon="clock" tone="amber" :animate="true" :hint="__('lms.dashboard.pending_grading_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.attendance_sessions')" :value="$attendanceSessions ?? 0" icon="calendar" tone="blue" :animate="true" :hint="__('lms.dashboard.attendance_sessions_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.announcements')" :value="$announcements ?? 0" icon="megaphone" tone="indigo" :animate="true" :hint="__('lms.dashboard.announcements_hint')" />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

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

        @if(isset($recentClasses) && count($recentClasses) > 0)
        <x-lms-section :title="__('lms.dashboard.recent_classes')" icon="clipboard" compact>
            <x-slot:headerActions>
                <a href="{{ route('instruktur.classes.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition">{{ __('lms.dashboard.view_all') }}</a>
            </x-slot:headerActions>
            <x-lms-panel>
                @foreach($recentClasses as $class)
                    <div class="lms-list-item">
                        <div class="min-w-0">
                            <p class="lms-list-item__title">{{ $class->title }}</p>
                            <p class="lms-list-item__meta">{{ $class->code }} • {{ $class->participants_count }}/{{ $class->quota }} {{ __('lms.dashboard.students') }}</p>
                        </div>
                        <x-lms-action-btn variant="view" :href="route('instruktur.classes.stream', $class)">{{ __('lms.dashboard.view_class') }}</x-lms-action-btn>
                    </div>
                @endforeach
            </x-lms-panel>
        </x-lms-section>
        @endif
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
