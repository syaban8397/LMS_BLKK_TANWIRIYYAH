<x-app-layout>
    <div class="instructor-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Instructor Dashboard"
            :subtitle="'Welcome back, ' . auth()->user()->name . '! Here\'s your teaching overview.'"
        >
            <x-slot:actions>
                <div class="hidden md:flex items-center gap-1 px-3 py-1.5 lms-badge lms-badge--info">
                    👨‍🏫 Instructor Panel
                </div>
            </x-slot:actions>
        </x-lms-page-header>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">My Classes</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $classes ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-xl">🏫</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total classes assigned</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Materials</p>
                        <p class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $materials ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-xl">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Learning resources uploaded</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Assignments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1 counter" data-value="{{ $assignments ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total assignments created</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Students</p>
                        <p class="text-3xl font-bold text-orange-500 mt-1 counter" data-value="{{ $participants ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-xl">👨‍🎓</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Enrolled participants</div>
            </div>
        </div>

        {{-- Aktivitas Ringkas --}}
        <div class="grid md:grid-cols-3 gap-5">
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Active Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $activeClasses ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Currently running</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Pending Grading</p>
                <h3 class="text-3xl font-bold text-yellow-500 mt-1 counter" data-value="{{ $pendingGrades ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Submissions to review</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Attendance Sessions</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $attendanceSessions ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Recorded sessions</div>
            </div>
        </div>

        {{-- Quick Access --}}
        <div class="quick-card p-5">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> Quick Access
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Instructor Tools</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    🏫 My Classes
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📖 Materials
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📝 Assignments
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📅 Attendance
                </a>
            </div>
        </div>

        {{-- Recent Classes (opsional) --}}
        @if(isset($recentClasses) && count($recentClasses) > 0)
        <div class="quick-card bg-white rounded-xl p-5 shadow-md border border-slate-200" style="animation-delay: 0.45s;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>📋</span> Recent Classes
                </h3>
                <a href="{{ route('instruktur.classes.index') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentClasses as $class)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100 hover:shadow-md transition">
                    <div>
                        <p class="font-medium text-slate-800">{{ $class->title }}</p>
                        <p class="text-xs text-slate-500">{{ $class->code }} • {{ $class->participants->count() }}/{{ $class->quota }} students</p>
                    </div>
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-action px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">View →</a>
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