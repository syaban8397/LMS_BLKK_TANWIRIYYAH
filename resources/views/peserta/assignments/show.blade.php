<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">{{ $assignment->title }}</h2>
                <p class="text-sm text-slate-500">{{ $class->title }}</p>
            </div>
            <a href="{{ route('peserta.assignments.index', $class) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back</a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-6 space-y-6">
        {{-- Detail Assignment --}}
        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex gap-3 text-sm">
                        <span>👤 {{ $assignment->creator->name }}</span>
                        <span>📅 Posted {{ $assignment->created_at->format('d M Y') }}</span>
                        <span>⏰ Deadline {{ $assignment->deadline->format('d M Y H:i') }}</span>
                    </div>
                </div>
                @if($assignment->deadline->isFuture())
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Closed</span>
                @endif
            </div>
            <h3 class="font-bold text-xl mb-4">Description</h3>
            <p class="text-slate-700 whitespace-pre-line">{{ $assignment->description }}</p>
            @if($assignment->attachment)
                <div class="mt-6 p-4 bg-slate-50 rounded-2xl">
                    <p class="font-semibold mb-2">📎 Attachment</p>
                    <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-blue-600 underline">Download file</a>
                </div>
            @endif
        </div>

        {{-- Submission Section --}}
        @php
            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
        @endphp

        @if($assignment->deadline->isFuture())
            <div class="bg-blue-50 border border-blue-200 rounded-3xl p-8">
                <h3 class="font-bold text-lg text-blue-900 mb-4">📤 Submit Your Work</h3>
                @if($submission)
                    @if($submission->isGraded())
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-4">
                            <p class="text-green-800">✅ Graded. Score: <strong>{{ $submission->score }}</strong></p>
                            @if($submission->feedback)<p class="text-sm text-green-700 mt-2">Feedback: {{ $submission->feedback }}</p>@endif
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 mb-4">
                            <p>Submitted on {{ $submission->submitted_at->format('d M Y H:i') }}. You can edit until deadline.</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('peserta.submissions.edit', [$class, $assignment, $submission]) }}" class="px-6 py-3 bg-amber-600 text-white rounded-2xl">✏️ Edit Submission</a>
                        </div>
                    @endif
                @else
                    <p class="text-blue-800 mb-6">Submit your assignment before deadline.</p>
                    <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-2xl">Submit Assignment</a>
                @endif
            </div>
        @else
            @if($submission)
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8">
                    <h3 class="font-bold text-lg mb-4">Submission Status</h3>
                    <p>Submitted: {{ $submission->submitted_at->format('d M Y H:i') }}</p>
                    @if($submission->isGraded())
                        <p class="mt-2">Score: <strong>{{ $submission->score }}</strong></p>
                        <p>Feedback: {{ $submission->feedback ?? '-' }}</p>
                    @else
                        <p class="text-amber-600 mt-2">Not graded yet.</p>
                    @endif
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center">
                    <p class="text-red-700">⚠️ Deadline passed. You did not submit.</p>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>