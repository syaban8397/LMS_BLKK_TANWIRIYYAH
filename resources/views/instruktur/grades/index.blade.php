<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        /* Animasi untuk card */
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        /* Animasi untuk baris tabel */
        @keyframes rowFadeIn {
            0% { opacity: 0; transform: translateX(-8px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .submissions-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Stats cards */
        .stats-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .stats-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(2deg);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.15);
        }
        /* Stagger delay untuk 4 stats cards */
        .stats-card:nth-child(1) { animation-delay: 0.05s; }
        .stats-card:nth-child(2) { animation-delay: 0.1s; }
        .stats-card:nth-child(3) { animation-delay: 0.15s; }
        .stats-card:nth-child(4) { animation-delay: 0.2s; }

        /* Table card 3D */
        .table-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.25s;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .table-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.12);
        }

        /* Baris tabel */
        .submission-row {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .submission-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }
        /* Stagger delay untuk baris (maksimal 50) */
        .submission-row:nth-child(1) { animation-delay: 0.3s; }
        .submission-row:nth-child(2) { animation-delay: 0.33s; }
        .submission-row:nth-child(3) { animation-delay: 0.36s; }
        .submission-row:nth-child(4) { animation-delay: 0.39s; }
        .submission-row:nth-child(5) { animation-delay: 0.42s; }
        .submission-row:nth-child(6) { animation-delay: 0.45s; }
        .submission-row:nth-child(7) { animation-delay: 0.48s; }
        .submission-row:nth-child(8) { animation-delay: 0.51s; }
        .submission-row:nth-child(9) { animation-delay: 0.54s; }
        .submission-row:nth-child(10) { animation-delay: 0.57s; }
        .submission-row:nth-child(11) { animation-delay: 0.6s; }
        .submission-row:nth-child(12) { animation-delay: 0.63s; }
        .submission-row:nth-child(13) { animation-delay: 0.66s; }
        .submission-row:nth-child(14) { animation-delay: 0.69s; }
        .submission-row:nth-child(15) { animation-delay: 0.72s; }
        .submission-row:nth-child(16) { animation-delay: 0.75s; }
        .submission-row:nth-child(17) { animation-delay: 0.78s; }
        .submission-row:nth-child(18) { animation-delay: 0.81s; }
        .submission-row:nth-child(19) { animation-delay: 0.84s; }
        .submission-row:nth-child(20) { animation-delay: 0.87s; }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Flash message */
        .flash-message {
            animation: cardPop3D 0.3s ease forwards;
        }
    </style>

    <div class="submissions-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $assignment->title }} - Submissions</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash-message bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-message bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stats-card bg-white rounded-xl p-4 shadow-md border border-slate-200 text-center">
                <p class="text-slate-500 text-sm">Total</p>
                <p class="text-3xl font-bold text-slate-800 counter" data-value="{{ $stats['total'] }}">0</p>
            </div>
            <div class="stats-card bg-green-50 rounded-xl p-4 shadow-md border border-green-200 text-center">
                <p class="text-green-600 text-sm">Submitted</p>
                <p class="text-3xl font-bold text-green-700 counter" data-value="{{ $stats['submitted'] }}">0</p>
            </div>
            <div class="stats-card bg-yellow-50 rounded-xl p-4 shadow-md border border-yellow-200 text-center">
                <p class="text-yellow-600 text-sm">Late</p>
                <p class="text-3xl font-bold text-yellow-700 counter" data-value="{{ $stats['late'] }}">0</p>
            </div>
            <div class="stats-card bg-blue-50 rounded-xl p-4 shadow-md border border-blue-200 text-center">
                <p class="text-blue-600 text-sm">Graded</p>
                <p class="text-3xl font-bold text-blue-700 counter" data-value="{{ $stats['graded'] }}">0</p>
            </div>
        </div>

        {{-- Submissions Table --}}
        <div class="table-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Student Submissions</h3>
                <p class="text-xs text-slate-500 mt-0.5">Grade each student's assignment</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Student</th>
                            <th class="px-6 py-4 text-left">Submitted At</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Score</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($submissions as $s)
                            <tr class="submission-row hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-800 font-medium">{{ $s->participant->name }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">{{ $s->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($s->status == 'graded')
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Graded</span>
                                    @elseif($s->status == 'late')
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Late</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Submitted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-slate-700">{{ $s->score ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('instruktur.grades.show', [$class, $assignment, $s]) }}" class="btn-3d px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                        Grade
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="text-4xl mb-2">📝</div>
                                    <p>No submissions yet.</p>
                                    <p class="text-xs text-slate-400 mt-1">Students haven't submitted this assignment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($submissions->hasPages())
                <div class="px-6 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $submissions->links() }}
                </div>
            @endif
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