<x-app-layout>
    <div class="instructor-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.dashboard.instruktur_title')"
            :subtitle="__('lms.dashboard.instruktur_subtitle', ['name' => auth()->user()->name])"
        >
            <x-slot:actions>
                <div class="hidden md:flex items-center gap-1 px-3 py-1.5 lms-badge lms-badge--info">
                    👨‍🏫 {{ __('lms.dashboard.instruktur_panel') }}
                </div>
            </x-slot:actions>
        </x-lms-page-header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.my_classes') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $classes ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">🏫</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.my_classes_hint') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.materials') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $materials ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.materials_hint') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.assignments') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $assignments ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.assignments_hint') }}</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">{{ __('lms.dashboard.students') }}</p>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-50 mt-1 counter" data-value="{{ $participants ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">👨‍🎓</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ __('lms.dashboard.students_enrolled') }}</div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.active_classes') }}</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $activeClasses ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.active_classes_hint') }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.pending_grading') }}</p>
                <h3 class="text-3xl font-bold text-yellow-500 mt-1 counter" data-value="{{ $pendingGrades ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.pending_grading_hint') }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.attendance_sessions') }}</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $attendanceSessions ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.attendance_sessions_hint') }}</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.dashboard.announcements') }}</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-1 counter" data-value="{{ $announcements ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">{{ __('lms.dashboard.announcements_hint') }}</div>
            </div>
        </div>

        <div class="quick-card p-5">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> {{ __('lms.dashboard.quick_access') }}
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">{{ __('lms.dashboard.instructor_tools') }}</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    🏫 {{ __('lms.dashboard.my_classes') }}
                </a>
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📖 {{ __('lms.dashboard.materials') }}
                </a>
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📝 {{ __('lms.dashboard.assignments') }}
                </a>
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📅 {{ __('lms.dashboard.attendance_sessions') }}
                </a>
            </div>
        </div>

        @if(isset($recentClasses) && count($recentClasses) > 0)
        <div class="quick-card bg-white rounded-xl p-5 shadow-md border border-slate-200" style="animation-delay: 0.45s;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>📋</span> {{ __('lms.dashboard.recent_classes') }}
                </h3>
                <a href="{{ route('instruktur.classes.index') }}" class="text-xs text-blue-600 hover:underline">{{ __('lms.dashboard.view_all') }}</a>
            </div>
            <div class="space-y-3">
                @foreach($recentClasses as $class)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100 hover:shadow-md transition">
                    <div>
                        <p class="font-medium text-slate-800">{{ $class->title }}</p>
                        <p class="text-xs text-slate-500">{{ $class->code }} • {{ $class->participants->count() }}/{{ $class->quota }} {{ __('lms.dashboard.students') }}</p>
                    </div>
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-action px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">{{ __('lms.dashboard.view_class') }}</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
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
