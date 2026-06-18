<x-app-layout>
<div class="peserta-assignment-show-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="$assignment->title"
            :subtitle="$class->title"
            :back-url="route('peserta.assignments.index', $class)"
            :back-label="__('lms.back')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.assignment.list'), 'url' => route('peserta.assignments.index', $class)],
                ['label' => $assignment->title],
            ]"
        />

        <x-lms-session-flash />

        {{-- Assignment Details Card --}}
        <div class="detail-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    {{ __('lms.assignment.details') }}
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="info-section flex flex-wrap justify-between items-start gap-3">
                    <div class="flex flex-wrap gap-4 text-xs text-slate-500">
                        <span>👤 {{ $assignment->creator->name }}</span>
                        <span>📅 {{ __('lms.assignment.posted_on', ['date' => $assignment->created_at->format('d M Y')]) }}</span>
                        <span>⏰ {{ __('lms.assignment.deadline_on', ['date' => $assignment->deadline->format('d M Y H:i')]) }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($assignment->deadline->isFuture())
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ __('lms.assignment.active') }}</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ __('lms.assignment.closed') }}</span>
                            @if($assignment->late_submission_allowed)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">⚠️ {{ __('lms.assignment.late_allowed_badge') }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">⛔ {{ __('lms.assignment.no_late_badge') }}</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="info-section pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide mb-2">{{ __('lms.common.description') }}</p>
                    <p class="text-slate-700 text-sm whitespace-pre-line">{{ $assignment->description }}</p>
                </div>

                @if($assignment->attachment)
                    <div class="info-section pt-2 border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-semibold mb-2">📎 {{ __('lms.common.attachment') }}</p>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">📄</span>
                                <span class="text-sm text-slate-700">{{ basename($assignment->attachment) }}</span>
                            </div>
                            <a href="{{ route('secure.assignments.attachment', [$class, $assignment]) }}" target="_blank" class="lms-action-btn lms-action-btn--view inline-flex items-center gap-1">
                                {{ __('lms.common.download') }}
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
                        <span>📤</span> {{ __('lms.assignment.submit_work') }}
                        @if($assignment->deadline->isPast() && $assignment->late_submission_allowed)
                            <span class="text-xs text-orange-600 font-medium bg-orange-100 px-2 py-0.5 rounded-full">{{ __('lms.assignment.late_allowed_badge') }}</span>
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
                                        <p class="text-green-800 font-medium">{{ __('lms.assignment.graded_message') }}</p>
                                        @if($submission->feedback)
                                            <p class="text-sm text-green-700 mt-2">{{ __('lms.assignment.feedback_label') }} {{ $submission->feedback }}</p>
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
                                            {{ __('lms.assignment.submitted_on', ['date' => $submission->submitted_at->format('d M Y H:i')]) }}
                                            @if($submission->status == 'late')
                                                <span class="ml-2 text-xs bg-orange-200 px-1.5 py-0.5 rounded-full">{{ __('lms.grade.late') }}</span>
                                            @endif
                                        </p>
                                        @if($assignment->deadline->isFuture())
                                            <p class="text-yellow-700 text-sm">{{ __('lms.assignment.edit_until_deadline') }}</p>
                                        @elseif($assignment->late_submission_allowed)
                                            <p class="text-orange-700 text-sm">{{ __('lms.assignment.edit_after_deadline_late') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('peserta.submissions.edit', [$class, $assignment, $submission]) }}" class="lms-btn-warning inline-flex items-center gap-1">
                                    ✏️ {{ __('lms.assignment.edit_submission') }}
                                </a>
                            </div>
                        @endif
                    @else
                        @if($assignment->deadline->isFuture())
                            <p class="text-blue-800 text-sm">{{ __('lms.assignment.submit_before_deadline') }}</p>
                        @else
                            <p class="text-orange-800 text-sm">{{ __('lms.assignment.submit_late_allowed') }}</p>
                        @endif
                        <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="lms-btn-primary inline-flex items-center gap-1">
                            {{ __('lms.assignment.submit_btn') }}
                        </a>
                    @endif
                </div>
            </div>
        @else
            {{-- Deadline passed and no late submission allowed --}}
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden border-l-4 border-l-red-500">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>⛔</span> {{ __('lms.assignment.submission_closed') }}
                    </h3>
                </div>
                <div class="p-5 text-center">
                    <div class="text-5xl mb-3">⛔</div>
                    <h4 class="text-lg font-bold text-red-800 mb-2">{{ __('lms.assignment.submission_not_available') }}</h4>
                    <p class="text-red-700">{{ __('lms.assignment.deadline_passed_no_late') }}</p>
                    @if($assignment->deadline)
                        <p class="text-sm text-red-600 mt-3">{{ __('lms.assignment.deadline_was', ['date' => $assignment->deadline->format('d M Y H:i')]) }}</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Show submitted content if exists (file/url/notes) --}}
        @if($submission && ($submission->file_path || $submission->url))
            <div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📎</span> {{ __('lms.assignment.your_submission') }}
                        @if($submission->status == 'late')
                            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full">{{ __('lms.grade.late') }}</span>
                        @endif
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    @if($submission->file_path)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <span class="text-sm text-slate-700">{{ __('lms.assignment.uploaded_file') }}</span>
                            <a href="{{ route('secure.submissions.file', [$class, $assignment, $submission]) }}" target="_blank" class="text-blue-600 text-sm hover:underline">{{ __('lms.common.download') }}</a>
                        </div>
                    @endif
                    @if($submission->url)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <span class="text-sm text-slate-700">{{ __('lms.assignment.link_label') }}</span>
                            <a href="{{ $submission->url }}" target="_blank" class="text-blue-600 text-sm hover:underline break-all">{{ $submission->url }}</a>
                        </div>
                    @endif
                    @if($submission->notes)
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-sm text-slate-700"><strong>{{ __('lms.assignment.notes_label') }}</strong> {{ $submission->notes }}</p>
                        </div>
                    @endif
                    @if($submission->isGraded() && $submission->feedback)
                        <div class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                            <p class="text-sm text-green-800"><strong>{{ __('lms.assignment.instructor_feedback') }}</strong></p>
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
                        <span>🏆</span> {{ __('lms.assignment.your_score') }}
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
