<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% {
                opacity: 0;
                transform: translateY(30px) rotateX(10deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0);
            }
        }

        /* Animasi untuk setiap card */
        @keyframes cardPop3D {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(20px) rotateX(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotateX(0);
            }
        }

        /* Wrapper utama */
        .show-program-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Stat card 3D */
        .stat-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .stat-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(2deg) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
        }

        /* Stagger delay untuk stat card (3 kartu) */
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }

        /* Info card dan deskripsi */
        .info-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .info-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        .info-card:nth-child(1) { animation-delay: 0.2s; }  /* Program Information */
        .info-card:nth-child(2) { animation-delay: 0.25s; } /* Description */
        .info-card:nth-child(3) { animation-delay: 0.3s; }  /* Action Buttons */

        /* Tombol aksi 3D */
        .btn-action {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-block;
        }
        .btn-action:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-action:active {
            transform: translateY(1px);
        }

        /* Badge status */
        .status-badge {
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: translateY(-1px) scale(1.02);
        }
    </style>

    <div class="show-program-wrapper space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $program->name }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Training Program Overview</p>
            </div>
            <div class="flex gap-2">
                @if($program->status == 'active')
                    <span class="status-badge inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium shadow-sm">
                        Active
                    </span>
                @else
                    <span class="status-badge inline-flex items-center px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium shadow-sm">
                        Inactive
                    </span>
                @endif
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Classes</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $program->classes()->count() }}</p>
                    </div>
                    <div class="text-xl">🏫</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Created At</p>
                        <p class="text-sm font-semibold text-green-700 mt-1">{{ $program->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">📅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Last Updated</p>
                        <p class="text-sm font-semibold text-purple-600 mt-1">{{ $program->updated_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">🔄</div>
                </div>
            </div>
        </div>

        {{-- Program Information --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span>📋</span> Program Information
            </h3>
            <div class="grid md:grid-cols-2 gap-x-5 gap-y-4 text-sm">
                <div>
                    <span class="text-slate-400 text-xs">Program Name</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Status</span>
                    <p class="font-medium text-slate-800 mt-0.5 capitalize">{{ $program->status }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Start Date</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->start_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">End Date</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->end_date->format('d M Y') }}</p>
                </div>
                @if($program->capacity)
                <div>
                    <span class="text-slate-400 text-xs">Capacity</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->capacity }} participants</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Description --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-2 flex items-center gap-2">
                <span>📝</span> Program Description
            </h3>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $program->description ?: 'No description available.' }}</p>
        </div>

        {{-- Action Buttons --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.programs.edit', $program) }}" 
                   class="btn-action px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                    ✏️ Edit Program
                </a>
                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Delete this training program?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        🗑️ Delete Program
                    </button>
                </form>
                <a href="{{ route('admin.programs.index') }}" 
                   class="btn-action px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Programs
                </a>
            </div>
        </div>
    </div>
</x-app-layout>