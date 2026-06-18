<x-app-layout>
    <div class="participant-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.dashboard.peserta_title')"
            :subtitle="__('lms.dashboard.peserta_subtitle', ['name' => auth()->user()->name])"
        >
            <x-slot:actions>
                <div class="hidden md:flex items-center gap-1 px-3 py-1.5 lms-badge lms-badge--info">
                    👨‍🎓 {{ __('lms.dashboard.peserta_panel') }}
                </div>
            </x-slot:actions>
        </x-lms-page-header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.my_classes') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $classes ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">🏫</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.my_classes_enrolled') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.materials') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $materials ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.materials_available') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.assignments') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $assignments ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.assignments_total') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.nav.certificates') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $certificates ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📜</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.earned_certificates') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.announcements') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $announcementCount ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📢</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.announcements_from_classes') }}</div>
            </div>
        </div>

        @if(isset($announcements) && $announcements->count() > 0)
        <div class="quick-card p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>📢</span> {{ __('lms.dashboard.latest_announcements') }}
                </h2>
                <a href="{{ route('peserta.classes.index') }}" class="text-xs text-blue-600 hover:underline">{{ __('lms.dashboard.view_classes') }}</a>
            </div>
            <div class="space-y-3">
                @foreach($announcements as $announcement)
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <p class="font-medium text-slate-800">{{ $announcement->title }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $announcement->class->title ?? __('lms.dashboard.class_fallback') }} • {{ $announcement->created_at->diffForHumans() }}</p>
                            </div>
                            @if($announcement->class)
                                <a href="{{ route('peserta.classes.stream', $announcement->class) }}" class="text-xs text-blue-600 hover:underline shrink-0">{{ __('lms.dashboard.read') }}</a>
                            @endif
                        </div>
                        <p class="text-sm text-slate-600 mt-2">{{ Str::limit($announcement->description, 120) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.completed_classes') }}</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $completedClasses ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.completed_classes_hint') }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.pending_assignments') }}</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1 counter" data-value="{{ $pendingAssignments ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.pending_assignments_hint') }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.material.progress_title') }}</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-1"><span class="counter" data-value="{{ $materialProgressPercentage ?? 0 }}">0</span>%</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.material.progress_summary', ['completed' => $completedMaterials ?? 0, 'total' => $materials ?? 0]) }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.attendance_rate') }}</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1"><span class="counter" data-value="{{ $attendancePercentage ?? 0 }}">0</span>%</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.attendance_rate_hint') }}</div>
            </div>
        </div>

        <div class="quick-card p-5">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> {{ __('lms.dashboard.quick_access') }}
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">{{ __('lms.dashboard.participant_menu') }}</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link">
                    <span class="lms-quick-link__icon">🏫</span>
                    <span>{{ __('lms.dashboard.my_classes') }}</span>
                </a>
                @if($primaryClass)
                    <a href="{{ route('peserta.materials.index', $primaryClass) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon">📖</span>
                        <span>{{ __('lms.dashboard.materials') }}</span>
                    </a>
                    <a href="{{ route('peserta.assignments.index', $primaryClass) }}" class="lms-quick-link">
                        <span class="lms-quick-link__icon">📝</span>
                        <span>{{ __('lms.dashboard.assignments') }}</span>
                    </a>
                @else
                    <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link lms-quick-link--muted" title="{{ __('lms.dashboard.enroll_first_hint') }}">
                        <span class="lms-quick-link__icon">📖</span>
                        <span>{{ __('lms.dashboard.materials') }}</span>
                    </a>
                    <a href="{{ route('peserta.classes.index') }}" class="lms-quick-link lms-quick-link--muted" title="{{ __('lms.dashboard.enroll_first_hint') }}">
                        <span class="lms-quick-link__icon">📝</span>
                        <span>{{ __('lms.dashboard.assignments') }}</span>
                    </a>
                @endif
                <a href="{{ route('peserta.certificates.index') }}" class="lms-quick-link">
                    <span class="lms-quick-link__icon">📜</span>
                    <span>{{ __('lms.nav.certificates') }}</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function animateCounter(el, value) {
            let start = 0;
            let end = parseInt(value);
            let step = Math.ceil(end / 40);
            let interval = setInterval(() => {
                start += step;
                if (start >= end) {
                    start = end;
                    clearInterval(interval);
                }
                el.innerText = start;
            }, 20);
        }
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.counter').forEach(el => {
                animateCounter(el, el.dataset.value);
            });
        });
    </script>
</x-app-layout>
