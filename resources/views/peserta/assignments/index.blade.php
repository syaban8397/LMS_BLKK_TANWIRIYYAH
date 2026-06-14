<x-app-layout>
    <div class="peserta-assignments-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Assignments"
            :subtitle="$class->title"
            :back-url="route('peserta.classes.stream', $class)"
            back-label="← Back to Class"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <x-lms-card class="assignments-card" title="Assignment List" :meta="'Total: ' . $assignments->total()">
            @if($assignments->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                    @foreach($assignments as $assignment)
                        @php
                            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                            $statusText = $submission ? ($submission->isGraded() ? 'Graded' : 'Submitted') : 'Not submitted';
                            $statusBadge = $submission
                                ? ($submission->isGraded() ? 'lms-badge--success' : 'lms-badge--warning')
                                : 'lms-badge--danger';
                            $isDeadlinePassed = $assignment->deadline->isPast();
                        @endphp
                        <div class="assignment-row p-5 transition group">
                            <div class="flex flex-wrap md:flex-nowrap items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $assignment->title }}</h3>
                                        <span class="lms-badge {{ $statusBadge }}">{{ $statusText }}</span>
                                        @if($isDeadlinePassed)
                                            <span class="lms-badge lms-badge--danger">⏰ Ended</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2">{{ $assignment->description }}</p>
                                    <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-500 dark:text-slate-400">
                                        <span>📅 Deadline: {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                        <span>📎 {{ $assignment->attachment ? 'Attachment available' : 'No file' }}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="lms-btn-primary btn-3d">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($assignments->hasPages())
                    <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40">
                        {{ $assignments->links() }}
                    </div>
                @endif
            @else
                <x-lms-empty-state icon="📋" title="No assignments available yet" class="border-0 shadow-none !py-10" />
            @endif
        </x-lms-card>
    </div>
</x-app-layout>
