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

        .attendance-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Table card 3D */
        .table-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .table-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.12);
        }

        /* Baris tabel */
        .attendance-row {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .attendance-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }
        /* Stagger delay untuk baris (maksimal 20) */
        .attendance-row:nth-child(1) { animation-delay: 0.1s; }
        .attendance-row:nth-child(2) { animation-delay: 0.15s; }
        .attendance-row:nth-child(3) { animation-delay: 0.2s; }
        .attendance-row:nth-child(4) { animation-delay: 0.25s; }
        .attendance-row:nth-child(5) { animation-delay: 0.3s; }
        .attendance-row:nth-child(6) { animation-delay: 0.35s; }
        .attendance-row:nth-child(7) { animation-delay: 0.4s; }
        .attendance-row:nth-child(8) { animation-delay: 0.45s; }
        .attendance-row:nth-child(9) { animation-delay: 0.5s; }
        .attendance-row:nth-child(10) { animation-delay: 0.55s; }
        .attendance-row:nth-child(11) { animation-delay: 0.6s; }
        .attendance-row:nth-child(12) { animation-delay: 0.65s; }
        .attendance-row:nth-child(13) { animation-delay: 0.7s; }
        .attendance-row:nth-child(14) { animation-delay: 0.75s; }
        .attendance-row:nth-child(15) { animation-delay: 0.8s; }
        .attendance-row:nth-child(16) { animation-delay: 0.85s; }
        .attendance-row:nth-child(17) { animation-delay: 0.9s; }
        .attendance-row:nth-child(18) { animation-delay: 0.95s; }
        .attendance-row:nth-child(19) { animation-delay: 1s; }
        .attendance-row:nth-child(20) { animation-delay: 1.05s; }

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
    </style>

    <div class="attendance-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Attendance Sessions</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} • Manage attendance per meeting</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.attendances.create', $class) }}" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                    + New Session
                </a>
                <a href="{{ route('instruktur.attendances.report', $class) }}" class="btn-3d px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                    📊 Report
                </a>
                <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('error') }}
            </div>
        @endif

        {{-- Sessions Table Card --}}
        <div class="table-card bg-white rounded-xl p-0 shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">Attendance Sessions</h3>
                <p class="text-xs text-slate-500 mt-0.5">Click View to see details, Edit to modify student status</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Meeting</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-center">✅ Present</th>
                            <th class="px-6 py-4 text-center">📝 Permission</th>
                            <th class="px-6 py-4 text-center">🤒 Sick</th>
                            <th class="px-6 py-4 text-center">❌ Absent</th>
                            <th class="px-6 py-4 text-center">Total</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meetings as $meeting)
                            @php
                                $stats = \App\Models\Attendance::where('class_id', $class->id)
                                    ->where('meeting_number', $meeting->meeting_number)
                                    ->get();
                                $present    = $stats->where('status','present')->count();
                                $permission = $stats->where('status','permission')->count();
                                $sick       = $stats->where('status','sick')->count();
                                $absent     = $stats->where('status','absent')->count();
                                $total      = $present + $permission + $sick + $absent;
                            @endphp
                            <tr class="attendance-row border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">Meeting {{ $meeting->meeting_number }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($meeting->attendance_date)->format('d F Y H:i') }}</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">{{ $present }}</td>
                                <td class="px-6 py-4 text-center text-yellow-600 font-semibold">{{ $permission }}</td>
                                <td class="px-6 py-4 text-center text-orange-600 font-semibold">{{ $sick }}</td>
                                <td class="px-6 py-4 text-center text-red-600 font-semibold">{{ $absent }}</td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $total }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('instruktur.attendances.show', [$class, $meeting->meeting_number]) }}" 
                                           class="btn-3d px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium transition shadow-sm">View</a>
                                        <a href="{{ route('instruktur.attendances.edit', [$class, $meeting->meeting_number]) }}" 
                                           class="btn-3d px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium transition shadow-sm">Edit</a>
                                        <form action="{{ route('instruktur.attendances.destroy', [$class, $meeting->meeting_number]) }}" 
                                              method="POST" onsubmit="return confirm('Delete this entire attendance session? This action cannot be undone.')" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-3d px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition shadow-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                    <div class="text-4xl mb-2">📅</div>
                                    <p>No attendance sessions yet.</p>
                                    <a href="{{ route('instruktur.attendances.create', $class) }}" class="text-blue-600 hover:underline mt-2 inline-block">Create first session</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>