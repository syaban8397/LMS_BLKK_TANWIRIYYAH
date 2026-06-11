<x-app-layout>
    <div class="space-y-6">
        {{-- Header (sederhana, tanpa gradien biru) --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Instructor Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ auth()->user()->name }}! Here's your teaching overview.</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-sm">
                👨‍🏫 Instructor Panel
            </div>
        </div>

        {{-- Statistik Cards (efek 3D) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">My Classes</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $classes ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-xl">🏫</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total classes assigned</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Materials</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $materials ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-xl">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Learning resources uploaded</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Assignments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $assignments ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total assignments created</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Students</p>
                        <p class="text-3xl font-bold text-orange-500 mt-1">{{ $participants ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-xl">👨‍🎓</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Enrolled participants</div>
            </div>
        </div>

        {{-- Aktivitas Ringkas (Active Classes, Pending Grades, Attendance) --}}
        <div class="grid md:grid-cols-3 gap-5">
            <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Active Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $activeClasses ?? 0 }}</h3>
                <div class="mt-2 text-xs text-slate-500">Currently running</div>
            </div>
            <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Pending Grading</p>
                <h3 class="text-3xl font-bold text-yellow-500 mt-1">{{ $pendingGrades ?? 0 }}</h3>
                <div class="mt-2 text-xs text-slate-500">Submissions to review</div>
            </div>
            <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Attendance Sessions</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $attendanceSessions ?? 0 }}</h3>
                <div class="mt-2 text-xs text-slate-500">Recorded sessions</div>
            </div>
        </div>

        {{-- Quick Access (efek 3D pada tombol) --}}
        <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> Quick Access
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Instructor Tools</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('instruktur.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    🏫 My Classes
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📖 Materials
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📝 Assignments
                </a>
                <a href="#" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📅 Attendance
                </a>
            </div>
        </div>

        {{-- Recent Classes (opsional, untuk melengkapi) --}}
        @if(isset($recentClasses) && count($recentClasses) > 0)
        <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>📋</span> Recent Classes
                </h3>
                <a href="{{ route('instruktur.classes.index') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentClasses as $class)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100 hover:shadow-sm transition">
                    <div>
                        <p class="font-medium text-slate-800">{{ $class->title }}</p>
                        <p class="text-xs text-slate-500">{{ $class->code }} • {{ $class->participants->count() }}/{{ $class->quota }} students</p>
                    </div>
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-action px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">View →</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <style>
        .stat-card {
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -8px rgba(0, 0, 0, 0.1);
        }
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .quick-btn {
            transition: all 0.2s ease;
        }
        .quick-btn:active {
            transform: translateY(1px);
        }
        .btn-action {
            transition: all 0.2s ease;
        }
        .btn-action:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>