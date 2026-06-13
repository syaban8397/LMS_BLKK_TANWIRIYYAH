<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .peserta-assignment-show-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Kartu detail assignment */
        .detail-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .detail-card:hover {
            transform: translateY(-4px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 15px 25px -10px rgba(0, 0, 0, 0.12);
        }

        /* Kartu submission */
        .submission-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .submission-card:nth-child(1) { animation-delay: 0.05s; }
        .submission-card:nth-child(2) { animation-delay: 0.1s; }
        .submission-card:nth-child(3) { animation-delay: 0.15s; }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Area informasi di dalam kartu */
        .info-section {
            animation: fadeSlideUp 0.3s ease forwards;
            opacity: 0;
        }
        .info-section:nth-child(1) { animation-delay: 0.2s; }
        .info-section:nth-child(2) { animation-delay: 0.25s; }
        .info-section:nth-child(3) { animation-delay: 0.3s; }
        .info-section:nth-child(4) { animation-delay: 0.35s; }
    </style>

    <div class="peserta-assignment-show-wrapper space-y-6">
        {{-- Header Sederhana dengan Tombol Back --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $assignment->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.assignments.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">{{ session('info') }}</div>
        @endif

        {{-- Assignment Details Card --}}
        <div class="detail-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Assignment Details
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="info-section flex flex-wrap justify-between items-start gap-3">
                    <div class="flex flex-wrap gap-4 text-xs text-slate-500">
                        <span>👤 {{ $assignment->creator->name }}</span>
                        <span>📅 Posted {{ $assignment->created_at->format('d M Y') }}</span>
                        <span>⏰ Deadline {{ $assignment->deadline->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($assignment->deadline->isFuture())
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Closed</span>
                            @if($assignment->late_submission_allowed)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">⚠️ Late allowed</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">⛔ No late submission</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="info-section pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide mb-2">Description</p>
                    <p class="text-slate-700 text-sm whitespace-pre-line">{{ $assignment->description }}</p>
                </div>

                @if($assignment->attachment)
                    <div class="info-section pt-2 border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-semibold mb-2">📎 Attachment</p>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">📄</span>
                                <span class="text-sm text-slate-700">{{ basename($assignment->attachment) }}</span>
                            </div>
                            <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Submission Section (3D Card dengan warna sesuai status) --}}
        @php
            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
            $canSubmit = $assignment->allowsSubmission();
        @endphp

        @if($canSubmit)
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden border-l-4 {{ $assignment->deadline->isFuture() ? 'border-l-blue-500' : 'border-l-orange-500' }}">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r {{ $assignment->deadline->isFuture() ? 'from-blue-50' : 'from-orange-50' }} to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📤</span> Submit Your Work
                        @if($assignment->deadline->isPast() && $assignment->late_submission_allowed)
                            <span class="text-xs text-orange-600 font-medium bg-orange-100 px-2 py-0.5 rounded-full">Late submission allowed</span>
                        @endif
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
                                        @if($submission->feedback)
                                            <p class="text-sm text-green-700 mt-2">Feedback: {{ $submission->feedback }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="{{ $submission->status == 'late' ? 'bg-orange-50 border-orange-200' : 'bg-yellow-50 border-yellow-200' }} rounded-xl p-4 border">
                                <div class="flex items-start gap-2">
                                    <span class="{{ $submission->status == 'late' ? 'text-orange-600' : 'text-yellow-600' }} text-lg">📋</span>
                                    <div>
                                        <p class="{{ $submission->status == 'late' ? 'text-orange-800' : 'text-yellow-800' }} font-medium">
                                            Submitted on {{ $submission->submitted_at->format('d M Y H:i') }}
                                            @if($submission->status == 'late')
                                                <span class="ml-2 text-xs bg-orange-200 px-1.5 py-0.5 rounded-full">Late</span>
                                            @endif
                                        </p>
                                        @if($assignment->deadline->isFuture())
                                            <p class="text-yellow-700 text-sm">You can edit until the deadline.</p>
                                        @elseif($assignment->late_submission_allowed)
                                            <p class="text-orange-700 text-sm">Deadline has passed, but you can still edit your submission (will be marked as late).</p>
                                        @endif
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
                        @if($assignment->deadline->isFuture())
                            <p class="text-blue-800 text-sm">Submit your assignment before the deadline. You can update your submission anytime before the deadline closes.</p>
                        @else
                            <p class="text-orange-800 text-sm">Deadline has passed, but late submissions are allowed. Your submission will be marked as "Late".</p>
                        @endif
                        <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Submit Assignment
                        </a>
                    @endif
                </div>
            </div>
        @else
            {{-- Deadline passed and no late submission allowed --}}
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden border-l-4 border-l-red-500">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>⛔</span> Submission Closed
                    </h3>
                </div>
                <div class="p-5 text-center">
                    <div class="text-5xl mb-3">⛔</div>
                    <h4 class="text-lg font-bold text-red-800 mb-2">Submission Not Available</h4>
                    <p class="text-red-700">The deadline for this assignment has passed and late submissions are not allowed.</p>
                    @if($assignment->deadline)
                        <p class="text-sm text-red-600 mt-3">Deadline was: {{ $assignment->deadline->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Show submitted content if exists (file/url/notes) --}}
        @if($submission && ($submission->file_path || $submission->url))
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📎</span> Your Submission
                        @if($submission->status == 'late')
                            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full">Late</span>
                        @endif
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    @if($submission->file_path)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <span class="text-sm text-slate-700">Uploaded File:</span>
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-blue-600 text-sm hover:underline">Download</a>
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
                    @if($submission->isGraded() && $submission->feedback)
                        <div class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                            <p class="text-sm text-green-800"><strong>Instructor Feedback:</strong></p>
                            <p class="text-sm text-green-700 mt-1">{{ $submission->feedback }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Jika ada submission yang sudah di-graded, tampilkan score --}}
        @if($submission && $submission->isGraded() && $submission->score)
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-green-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>🏆</span> Your Score
                    </h3>
                </div>
                <div class="p-5 text-center">
                    <div class="text-4xl font-bold text-green-600">{{ $submission->score }}<span class="text-lg text-slate-500">/100</span></div>
                    @if($submission->feedback)
                        <p class="text-slate-600 text-sm mt-2">{{ $submission->feedback }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>