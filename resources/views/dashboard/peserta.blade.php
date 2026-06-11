<x-app-layout>
    <div class="space-y-6">
        {{-- Header sederhana tanpa hero --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Participant Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-sm">
                👨‍🎓 Participant Panel
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
                <div class="mt-3 text-xs text-slate-500">Enrolled classes</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Materials</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $materials ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-xl">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Available learning resources</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Assignments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $assignments ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total assignments</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Certificates</p>
                        <p class="text-3xl font-bold text-orange-500 mt-1">{{ $certificates ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-xl">📜</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Earned certificates</div>
            </div>
        </div>

        {{-- Progress Cards (3 kolom) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="dashboard-card bg-green-50 rounded-xl p-5 shadow-md border border-green-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Completed Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $completedClasses ?? 0 }}</h3>
                <div class="mt-2 text-xs text-slate-500">Finished classes</div>
            </div>
            <div class="dashboard-card bg-yellow-50 rounded-xl p-5 shadow-md border border-yellow-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Pending Assignments</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $pendingAssignments ?? 0 }}</h3>
                <div class="mt-2 text-xs text-slate-500">Need to submit</div>
            </div>
            <div class="dashboard-card bg-blue-50 rounded-xl p-5 shadow-md border border-blue-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Attendance Rate</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $attendancePercentage ?? 0 }}%</h3>
                <div class="mt-2 text-xs text-slate-500">Overall attendance</div>
            </div>
        </div>

        {{-- Quick Access (efek 3D pada tombol) --}}
        <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>⚡</span> Quick Access
                </h2>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Participant Menu</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('peserta.classes.index') }}" class="quick-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    🏫 My Classes
                </a>
                <a href="#" class="quick-btn bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📖 Materials
                </a>
                <a href="#" class="quick-btn bg-purple-600 hover:bg-purple-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📝 Assignments
                </a>
                <a href="#" class="quick-btn bg-orange-600 hover:bg-orange-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    📜 Certificates
                </a>
            </div>
        </div>
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
    </style>
</x-app-layout>