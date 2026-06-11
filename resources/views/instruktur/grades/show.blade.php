<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div><h2 class="text-2xl font-bold">Grade Submission</h2><p>{{ $assignment->title }} - {{ $submission->participant->name }}</p></div>
            <a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back</a>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl shadow p-8 space-y-6">
            <div>
                <h3 class="font-bold mb-2">Student's Work</h3>
                @if($submission->file_path)
                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-blue-600 underline">Download File</a>
                @endif
                @if($submission->url)
                    <p>🔗 <a href="{{ $submission->url }}" target="_blank" class="text-blue-600">{{ $submission->url }}</a></p>
                @endif
                @if($submission->notes)
                    <p class="mt-2 text-slate-600">{{ $submission->notes }}</p>
                @endif
                <p class="text-sm text-slate-500 mt-2">Submitted: {{ $submission->submitted_at->format('d M Y H:i') }}</p>
            </div>
            <form action="{{ route('instruktur.grades.store', [$class, $assignment, $submission]) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block font-semibold">Score (0-100)</label>
                        <input type="number" name="score" step="0.01" min="0" max="100" value="{{ old('score', $submission->score) }}" required class="w-40 border rounded-2xl p-2">
                    </div>
                    <div>
                        <label class="block font-semibold">Feedback</label>
                        <textarea name="feedback" rows="4" class="w-full border rounded-2xl p-3">{{ old('feedback', $submission->feedback) }}</textarea>
                    </div>
                </div>
                <div class="border-t mt-8 pt-6 flex justify-end gap-3">
                    <a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="px-6 py-3 bg-slate-100 rounded-2xl">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-2xl">Save Grade</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>