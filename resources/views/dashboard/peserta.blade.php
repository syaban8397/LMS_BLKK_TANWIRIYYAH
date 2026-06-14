<x-app-layout>
    <div class="participant-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Participant Dashboard"
            :subtitle="'Welcome back, ' . auth()->user()->name . '!'"
        >
            <x-slot:actions>
                <div class="hidden md:flex items-center gap-1 px-3 py-1.5 lms-badge lms-badge--info">
                    👨‍🎓 Participant Panel
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
                <div class="mt-3 text-xs text-slate-500">Enrolled classes</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Materials</p>
                        <p class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $materials ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-xl">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Available learning resources</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Assignments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1 counter" data-value="{{ $assignments ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total assignments</div>
            </div>
            <div class="stat-card p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Certificates</p>
                        <p class="text-3xl font-bold text-orange-500 mt-1 counter" data-value="{{ $certificates ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-xl">📜</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Earned certificates</div>
            </div>
        </div>

        {{-- Progress Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Completed Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $completedClasses ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Finished classes</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Pending Assignments</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1 counter" data-value="{{ $pendingAssignments ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Need to submit</div>
            </div>
            <div class="progress-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Attendance Rate</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $attendancePercentage ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Overall attendance</div>
            </div>
        </div>

        {{-- Quick Access --}}
        <div class="quick-card p-5">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> Quick Access
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Participant Menu</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('peserta.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    🏫 My Classes
                </a>
                <a href="#" class="quick-btn bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📖 Materials
                </a>
                <a href="#" class="quick-btn bg-purple-600 hover:bg-purple-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📝 Assignments
                </a>
                <a href="{{ route('peserta.certificates.index') }}" class="quick-btn bg-orange-600 hover:bg-orange-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
                    📜 Certificates
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