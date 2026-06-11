{{-- resources/views/instruktur/grades/show.blade.php --}}
<x-app-layout>
    {{-- Tidak ada header, hanya tombol back di kanan atas --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back
        </a>
    </div>

    <div class="max-w-5xl mx-auto space-y-5">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Card: Informasi Submission --}}
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-5 py-3 border-b border-slate-200">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Submission Details
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Student</p>
                        <p class="text-gray-800 font-medium">{{ $submission->participant->name }}</p>
                        <p class="text-xs text-gray-400">{{ $submission->participant->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Assignment</p>
                        <p class="text-gray-800 font-medium">{{ $assignment->title }}</p>
                        <p class="text-xs text-gray-400">{{ $class->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Submitted At</p>
                        <p class="text-gray-800">{{ $submission->submitted_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Status</p>
                        @if($submission->status == 'graded')
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Graded</span>
                        @elseif($submission->status == 'late')
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">Late</span>
                        @else
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700">Submitted</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Current Score</p>
                        <p class="text-gray-800 font-bold">{{ $submission->score ?? '-' }}</p>
                    </div>
                </div>

                {{-- Lampiran file --}}
                @if($submission->file_path)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Attachment</p>
                        <div class="flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-lg">📄</div>
                                <div><p class="font-semibold text-gray-800 text-xs">{{ basename($submission->file_path) }}</p></div>
                            </div>
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs rounded-lg shadow-sm transition">Download</a>
                        </div>
                    </div>
                @endif

                {{-- URL / YouTube --}}
                @if($submission->url)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Link Submission</p>
                        @php
                            $isYoutube = preg_match('/(youtube\.com|youtu\.be)/', $submission->url);
                            $videoId = null;
                            if ($isYoutube) {
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $submission->url, $match);
                                $videoId = $match[1] ?? null;
                            }
                        @endphp
                        @if($isYoutube && $videoId)
                            <div class="aspect-video rounded-xl overflow-hidden shadow-sm">
                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
                            </div>
                            <div class="mt-2 text-center">
                                <a href="{{ $submission->url }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 text-xs hover:underline">Open on YouTube</a>
                            </div>
                        @else
                            <a href="{{ $submission->url }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 text-sm hover:underline break-all">{{ $submission->url }}</a>
                        @endif
                    </div>
                @endif

                {{-- Catatan siswa --}}
                @if($submission->notes)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-1">Student's Notes</p>
                        <div class="bg-gray-50 rounded-xl p-3 text-sm text-gray-700">{{ $submission->notes }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card: Form Nilai dan Feedback --}}
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-5 py-3 border-b border-slate-200">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Give Grade & Feedback
                </h3>
            </div>
            <div class="p-5">
                <form action="{{ route('instruktur.grades.store', [$class, $assignment, $submission]) }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Score (0-100)</label>
                        <input type="number" name="score" step="0.01" min="0" max="100" 
                               value="{{ old('score', $submission->score) }}" required
                               class="w-40 rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-3 py-2">
                        @error('score')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Feedback</label>
                        <textarea name="feedback" rows="4" 
                                  class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-3 py-2"
                                  placeholder="Provide constructive feedback...">{{ old('feedback', $submission->feedback) }}</textarea>
                        @error('feedback')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex justify-end gap-2">
                        <a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>