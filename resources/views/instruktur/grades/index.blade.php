<x-app-layout>
    <div class="space-y-6">
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
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="dashboard-card bg-white rounded-xl p-4 shadow-md border border-slate-200 text-center">
                <p class="text-slate-500 text-sm">Total</p>
                <p class="text-3xl font-bold text-slate-800">{{ $stats['total'] }}</p>
            </div>
            <div class="dashboard-card bg-green-50 rounded-xl p-4 shadow-md border border-green-200 text-center">
                <p class="text-green-600 text-sm">Submitted</p>
                <p class="text-3xl font-bold text-green-700">{{ $stats['submitted'] }}</p>
            </div>
            <div class="dashboard-card bg-yellow-50 rounded-xl p-4 shadow-md border border-yellow-200 text-center">
                <p class="text-yellow-600 text-sm">Late</p>
                <p class="text-3xl font-bold text-yellow-700">{{ $stats['late'] }}</p>
            </div>
            <div class="dashboard-card bg-blue-50 rounded-xl p-4 shadow-md border border-blue-200 text-center">
                <p class="text-blue-600 text-sm">Graded</p>
                <p class="text-3xl font-bold text-blue-700">{{ $stats['graded'] }}</p>
            </div>
        </div>

        {{-- Submissions Table --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
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
                            <tr class="hover:bg-slate-50 transition">
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

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>