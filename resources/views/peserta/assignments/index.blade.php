<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Assignments</h2>
                <p class="text-sm text-slate-500">{{ $class->title }}</p>
            </div>
            <a href="{{ route('peserta.classes.stream', $class) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back to Class</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">
            <div class="divide-y">
                @forelse($assignments as $assignment)
                @php
                    $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                    $statusText = $submission ? ($submission->isGraded() ? 'Graded ('.$submission->score.')' : 'Submitted') : 'Not submitted';
                    $statusClass = $submission ? ($submission->isGraded() ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') : 'bg-red-100 text-red-700';
                @endphp
                <div class="p-6 hover:bg-slate-50">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-bold text-slate-800">{{ $assignment->title }}</h3>
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">{{ $statusText }}</span>
                            </div>
                            <p class="text-sm text-slate-600 line-clamp-2">{{ $assignment->description }}</p>
                            <div class="flex gap-4 mt-3 text-xs text-slate-500">
                                <span>📅 Deadline: {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                <span>📎 {{ $assignment->attachment ? 'Attachment' : 'No file' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm">View</a>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">No assignments yet.</div>
                @endforelse
            </div>
            <div class="p-4">{{ $assignments->links() }}</div>
        </div>
    </div>
</x-app-layout>