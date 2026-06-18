<x-app-layout>
<div class="peserta-assignment-show-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$assignment->title"
            :subtitle="$class->title . ' • Deadline: ' . $assignment->deadline->format('d M Y H:i')"
            :back-url="route('peserta.assignments.index', $class)"
            back-label="← Kembali ke Tugas"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        {{-- Assignment Info Card --}}
        <div class="detail-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Assignment Details
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="info-section">
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Title</p>
                    <p class="text-slate-800 font-semibold text-lg">{{ $assignment->title }}</p>
                </div>
                <div class="info-section">
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide mb-1">Description</p>
                    <p class="text-slate-700 text-sm whitespace-pre-line">{{ $assignment->description }}</p>
                </div>
                <div class="info-section grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Due Date</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $assignment->deadline->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Instructor</p>
                        <p class="text-slate-800 font-medium text-sm">{{ $assignment->creator->name }}</p>
                    </div>
                </div>
                @if($assignment->attachment)
                    <div class="info-section pt-2 border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-semibold mb-2">Attachment</p>
                        <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 text-sm hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            {{ basename($assignment->attachment) }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action / Submission Section (3D) --}}
        @php
            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
        @endphp

        @if($assignment->deadline->isFuture())
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden border-l-4 border-l-blue-500">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📤</span> Submit Your Work
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    @if($submission)
                        @if($submission->isGraded())
                            <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 text-lg">✅</span>
                                    <div>
                                        <p class="text-green-800 font-medium">Your submission has been graded</p>
                                        <p class="text-green-700 text-sm mt-1">Score: <strong>{{ $submission->score }}</strong></p>
                                        @if($submission->feedback)
                                            <p class="text-sm text-green-700 mt-2">Feedback: {{ $submission->feedback }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                <div class="flex items-start gap-2">
                                    <span class="text-yellow-600 text-lg">📋</span>
                                    <div>
                                        <p class="text-yellow-800 font-medium">You have submitted on {{ $submission->submitted_at->format('d M Y H:i') }}</p>
                                        <p class="text-yellow-700 text-sm">You can edit until the deadline.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('peserta.submissions.edit', [$class, $assignment, $submission]) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                    ✏️ Edit Submission
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-blue-800 text-sm">Submit your assignment before the deadline. You can update your submission anytime before the deadline closes.</p>
                        <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Submit Assignment
                        </a>
                    @endif
                </div>
            </div>
        @else
            @if($submission)
                <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <span>📊</span> Submission Status
                        </h3>
                    </div>
                    <div class="p-5 space-y-3">
                        <p class="text-slate-700 text-sm">Submitted on: <strong>{{ $submission->submitted_at->format('d M Y H:i') }}</strong></p>
                        @if($submission->isGraded())
                            <div class="bg-green-50 rounded-xl p-3 border border-green-200">
                                <p class="text-green-800">Score: <strong>{{ $submission->score }}</strong></p>
                                <p class="text-green-700 text-sm mt-1">Feedback: {{ $submission->feedback ?? '-' }}</p>
                            </div>
                        @else
                            <div class="bg-amber-50 rounded-xl p-3 border border-amber-200">
                                <p class="text-amber-700">Not graded yet. Please wait for the instructor's feedback.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden border-l-4 border-l-red-500">
                    <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <span>⚠️</span> Deadline Passed
                        </h3>
                    </div>
                    <div class="p-5 text-center">
                        <p class="text-red-700">You did not submit this assignment.</p>
                    </div>
                </div>
            @endif
        @endif

        {{-- If submission exists, show submitted file/link (optional) --}}
        @if($submission && ($submission->file_path || $submission->url))
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📎</span> Your Submission
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    @if($submission->file_path)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <span class="text-sm text-slate-700">Uploaded File:</span>
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-blue-600 text-sm hover:underline">Unduh</a>
                        </div>
                    @endif
                    @if($submission->url)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <span class="text-sm text-slate-700">Link:</span>
                            <a href="{{ $submission->url }}" target="_blank" class="text-blue-600 text-sm hover:underline break-all">{{ $submission->url }}</a>
                        </div>
                    @endif
                    @if($submission->notes)
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-sm text-slate-700"><strong>Notes:</strong> {{ $submission->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>