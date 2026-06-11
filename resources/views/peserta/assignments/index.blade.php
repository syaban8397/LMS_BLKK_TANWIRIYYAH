<x-app-layout>
    <div class="space-y-6">
        {{-- Header Sederhana dengan Tombol Back --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Assignments</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Class
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Assignments Card (3D) --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Assignment List</h3>
                <span class="text-xs text-slate-400">Total: {{ $assignments->total() }}</span>
            </div>

            @if($assignments->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($assignments as $assignment)
                        @php
                            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                            $statusText = $submission ? ($submission->isGraded() ? 'Graded ('.$submission->score.')' : 'Submitted') : 'Not submitted';
                            $statusClass = $submission ? ($submission->isGraded() ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') : 'bg-red-100 text-red-700';
                            $isDeadlinePassed = $assignment->deadline->isPast();
                        @endphp
                        <div class="p-5 hover:bg-slate-50 transition group">
                            <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="font-bold text-slate-800 text-lg group-hover:text-blue-600 transition">{{ $assignment->title }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ $statusText }}</span>
                                        @if($isDeadlinePassed)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">⏰ Ended</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-slate-600 line-clamp-2">{{ $assignment->description }}</p>
                                    <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-500">
                                        <span>📅 Deadline: {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                        <span>📎 {{ $assignment->attachment ? 'Attachment available' : 'No file' }}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($assignments->hasPages())
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
                        {{ $assignments->links() }}
                    </div>
                @endif
            @else
                <div class="p-8 text-center">
                    <div class="flex flex-col items-center text-slate-400">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm">No assignments available yet.</p>
                    </div>
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