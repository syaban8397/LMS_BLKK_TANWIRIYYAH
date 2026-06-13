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

        /* Animasi untuk setiap kartu (staggered) */
        @keyframes cardPop3D {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px) rotateX(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotateX(0);
            }
        }

        /* Animasi untuk baris tabel */
        @keyframes rowFadeIn {
            0% {
                opacity: 0;
                transform: translateX(-8px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Wrapper utama */
        .programs-wrapper {
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

        /* Stagger delay untuk 3 kartu */
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }

        /* Tabel dengan efek baris */
        .programs-table {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.2s;
        }

        .programs-table tbody tr {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
        }

        /* Stagger untuk baris tabel (maksimal 10) */
        .programs-table tbody tr:nth-child(1) { animation-delay: 0.25s; }
        .programs-table tbody tr:nth-child(2) { animation-delay: 0.3s; }
        .programs-table tbody tr:nth-child(3) { animation-delay: 0.35s; }
        .programs-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .programs-table tbody tr:nth-child(5) { animation-delay: 0.45s; }
        .programs-table tbody tr:nth-child(6) { animation-delay: 0.5s; }
        .programs-table tbody tr:nth-child(7) { animation-delay: 0.55s; }
        .programs-table tbody tr:nth-child(8) { animation-delay: 0.6s; }
        .programs-table tbody tr:nth-child(9) { animation-delay: 0.65s; }
        .programs-table tbody tr:nth-child(10) { animation-delay: 0.7s; }

        /* Tombol aksi 3D */
        .btn-action {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            display: inline-block;
        }
        .btn-action:hover {
            transform: translateY(-2px) scale(1.05);
            filter: brightness(1.05);
        }
        .btn-action:active {
            transform: translateY(1px);
        }

        /* Tombol create 3D */
        .btn-create {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .btn-create:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class="programs-wrapper space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Training Programs</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage all training programs available in the LMS.</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" 
               class="btn-create inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">
                + New Program
            </a>
        </div>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Programs</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalPrograms }}</p>
                    </div>
                    <div class="text-xl">📚</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Active Programs</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activePrograms }}</p>
                    </div>
                    <div class="text-xl">✅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Inactive Programs</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $inactivePrograms }}</p>
                    </div>
                    <div class="text-xl">⏸️</div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="programs-table bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-center">Period</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Classes</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($programs as $program)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $program->name }}</div>
                                    <div class="text-xs text-slate-500">{{ Str::limit($program->description, 70) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 text-xs">
                                    {{ $program->start_date->format('d M Y') }} - {{ $program->end_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($program->status == 'active')
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-700 font-medium text-xs">
                                    {{ $program->classes_count }}/{{ $program->capacity }} kelas
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.programs.show', $program) }}" class="btn-action px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">View</a>
                                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-action px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs transition shadow-sm">Edit</a>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Delete this program?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition shadow-sm">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-sm">No training programs available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 text-xs">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>