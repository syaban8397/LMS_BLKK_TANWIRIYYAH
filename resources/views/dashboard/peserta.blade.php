<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.dashboard.peserta_title')"
            :subtitle="__('lms.dashboard.peserta_subtitle', ['name' => auth()->user()->name])"
            :badge="__('lms.dashboard.peserta_panel')"
        />

        <x-lms-section :title="__('lms.dashboard.overview')" icon="chart" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--5">
                    <x-lms-stat-card :label="__('lms.dashboard.my_classes')" :value="$classes ?? 0" icon="building" tone="blue" :animate="true" :hint="__('lms.dashboard.my_classes_enrolled')" />
                    <x-lms-stat-card :label="__('lms.dashboard.materials')" :value="$materials ?? 0" icon="book" tone="green" :animate="true" :hint="__('lms.dashboard.materials_available')" />
                    <x-lms-stat-card :label="__('lms.dashboard.assignments')" :value="$assignments ?? 0" icon="document" tone="amber" :animate="true" :hint="__('lms.dashboard.assignments_total')" />
                    <x-lms-stat-card :label="__('lms.nav.certificates')" :value="$certificates ?? 0" icon="certificate" tone="indigo" :animate="true" :hint="__('lms.dashboard.earned_certificates')" />
                    <x-lms-stat-card :label="__('lms.dashboard.announcements')" :value="$announcementCount ?? 0" icon="megaphone" tone="blue" :animate="true" :hint="__('lms.dashboard.announcements_from_classes')" />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.dashboard.progress')" icon="chart" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--4">
                    <x-lms-stat-card :label="__('lms.dashboard.completed_classes')" :value="$completedClasses ?? 0" icon="check-circle" tone="green" :animate="true" :hint="__('lms.dashboard.completed_classes_hint')" />
                    <x-lms-stat-card :label="__('lms.dashboard.pending_assignments')" :value="$pendingAssignments ?? 0" icon="clock" tone="amber" :animate="true" :hint="__('lms.dashboard.pending_assignments_hint')" />
                    <x-lms-stat-card :label="__('lms.material.progress_title')" :value="$materialProgressPercentage ?? 0" icon="book" tone="indigo" :animate="true" suffix="%" :hint="__('lms.material.progress_summary', ['completed' => $completedMaterials ?? 0, 'total' => $materials ?? 0])" />
                    <x-lms-stat-card :label="__('lms.dashboard.attendance_rate')" :value="$attendancePercentage ?? 0" icon="calendar" tone="blue" :animate="true" suffix="%" :hint="__('lms.dashboard.attendance_rate_hint')" />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        @if(isset($announcements) && $announcements->count() > 0)
        <x-lms-section :title="__('lms.dashboard.latest_announcements')" icon="megaphone" compact>
            <x-slot:headerActions>
                <a href="{{ route('peserta.classes.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition">{{ __('lms.dashboard.view_classes') }}</a>
            </x-slot:headerActions>
            <x-lms-panel>
                @foreach($announcements as $announcement)
                    <div class="lms-list-item">
                        <div class="min-w-0 flex-1">
                            <p class="lms-list-item__title">{{ $announcement->title }}</p>
                            <p class="lms-list-item__meta">{{ $announcement->class->title ?? __('lms.dashboard.class_fallback') }} • {{ $announcement->created_at->diffForHumans() }}</p>
                            <p class="lms-list-item__body">{{ Str::limit($announcement->description, 120) }}</p>
                        </div>
                        @if($announcement->class)
                            <a href="{{ route('peserta.classes.stream', $announcement->class) }}" class="lms-btn-secondary text-xs shrink-0">{{ __('lms.dashboard.read') }}</a>
                        @endif
                    </div>
                @endforeach
            </x-lms-panel>
        </x-lms-section>
        @endif

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
    </x-lms-page-shell>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.counter').forEach(el => {
                const end = parseInt(el.dataset.value) || 0;
                const suffix = el.querySelector('.lms-stat-card__suffix');
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
