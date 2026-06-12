<x-app-layout>
    <style>
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .participant-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        .stat-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .stat-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(2deg);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }

        .progress-card {
            animation: fadeSlideUp 0.4s ease forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .progress-card:hover {
            transform: translateY(-4px) rotateX(1deg);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
        }
        .progress-card:nth-child(1) { animation-delay: 0.25s; }
        .progress-card:nth-child(2) { animation-delay: 0.3s; }
        .progress-card:nth-child(3) { animation-delay: 0.35s; }

        .quick-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.4s;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .quick-card:hover {
            transform: translateY(-4px) rotateX(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.1);
        }

        .quick-btn {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
        }
        .quick-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .quick-btn:active {
            transform: translateY(1px);
        }
    </style>

    <div class="participant-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Participant Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-md">
                👨‍🎓 Participant Panel
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">My Classes</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $classes ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-xl">🏫</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Enrolled classes</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Materials</p>
                        <p class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $materials ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-xl">📖</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Available learning resources</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Assignments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1 counter" data-value="{{ $assignments ?? 0 }}">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">📝</div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Total assignments</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
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
            <div class="progress-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Completed Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1 counter" data-value="{{ $completedClasses ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Finished classes</div>
            </div>
            <div class="progress-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Pending Assignments</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1 counter" data-value="{{ $pendingAssignments ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Need to submit</div>
            </div>
            <div class="progress-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Attendance Rate</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1 counter" data-value="{{ $attendancePercentage ?? 0 }}">0</h3>
                <div class="mt-2 text-xs text-slate-500">Overall attendance</div>
            </div>
        </div>

        {{-- Quick Access --}}
        <div class="quick-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
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
                <a href="#" class="quick-btn bg-orange-600 hover:bg-orange-700 text-white p-3 rounded-lg text-sm font-medium text-center transition shadow-md hover:shadow-lg">
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