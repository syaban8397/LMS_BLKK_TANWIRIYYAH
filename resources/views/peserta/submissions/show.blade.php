{{-- ACTION --}}
@php
    $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
@endphp

@if($assignment->deadline->isFuture())
    <div class="bg-blue-50 border border-blue-200 rounded-3xl p-8">
        <h3 class="font-bold text-lg text-blue-900 mb-4">📤 Submit Your Work</h3>
        
        @if($submission)
            @if($submission->isGraded())
                <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-4">
                    <p class="text-green-800">✅ Your submission has been graded. Score: <strong>{{ $submission->score }}</strong></p>
                    @if($submission->feedback)
                        <p class="text-sm text-green-700 mt-2">Feedback: {{ $submission->feedback }}</p>
                    @endif
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 mb-4">
                    <p>You have submitted on {{ $submission->submitted_at->format('d M Y H:i') }}. You can edit until deadline.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('peserta.submissions.edit', [$class, $assignment, $submission]) }}" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-2xl">✏️ Edit Submission</a>
                </div>
            @endif
        @else
            <p class="text-blue-800 mb-6">Submit your assignment before the deadline. You can update your submission anytime before the deadline closes.</p>
            <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-medium transition">Submit Assignment</a>
        @endif
    </div>
@else
    @if($submission)
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8">
            <h3 class="font-bold text-lg mb-4">Submission Status</h3>
            <p>Submitted on: {{ $submission->submitted_at->format('d M Y H:i') }}</p>
            @if($submission->isGraded())
                <p>Score: <strong>{{ $submission->score }}</strong></p>
                <p>Feedback: {{ $submission->feedback ?? '-' }}</p>
            @else
                <p class="text-amber-600">Not graded yet.</p>
            @endif
        </div>
    @else
        <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center">
            <p class="text-red-700">⚠️ Deadline has passed. You did not submit this assignment.</p>
        </div>
    @endif
@endif