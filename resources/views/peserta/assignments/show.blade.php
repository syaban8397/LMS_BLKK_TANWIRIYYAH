<x-app-layout>
    <x-lms-page-shell>
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

        @php
            $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
            $canSubmit = $assignment->allowsSubmission();
        @endphp

        <x-lms-section :title="__('lms.assignment.details')" icon="document" compact>
            <x-lms-panel>
                <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <x-lms-meta-chip icon="users">{{ $assignment->creator->name }}</x-lms-meta-chip>
                        <x-lms-meta-chip icon="calendar">{{ __('lms.assignment.posted_on', ['date' => $assignment->created_at->format('d M Y')]) }}</x-lms-meta-chip>
                        <x-lms-meta-chip icon="clock">{{ __('lms.assignment.deadline_on', ['date' => $assignment->deadline->format('d M Y H:i')]) }}</x-lms-meta-chip>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($assignment->deadline->isFuture())
                            <span class="lms-badge lms-badge--success">{{ __('lms.assignment.active') }}</span>
                        @else
                            <span class="lms-badge lms-badge--danger">{{ __('lms.assignment.closed') }}</span>
                            @if($assignment->late_submission_allowed)
                                <span class="lms-badge lms-badge--warning">{{ __('lms.assignment.late_allowed_badge') }}</span>
                            @else
                                <span class="lms-badge lms-badge--danger">{{ __('lms.assignment.no_late_badge') }}</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="lms-detail-list border-t border-slate-100 pt-4">
                    <div class="lms-detail-row">
                        <span class="lms-detail-row__label">{{ __('lms.common.description') }}</span>
                        <span class="lms-detail-row__value whitespace-pre-line">{{ $assignment->description }}</span>
                    </div>
                </div>

                @if($assignment->attachment)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">{{ __('lms.common.attachment') }}</p>
                        <div class="lms-attachment-row">
                            <div class="lms-attachment-row__main">
                                <x-lms-file-icon type="{{ pathinfo($assignment->attachment, PATHINFO_EXTENSION) }}" />
                                <span class="text-sm text-slate-700 truncate">{{ basename($assignment->attachment) }}</span>
                            </div>
                            <a href="{{ route('secure.assignments.attachment', [$class, $assignment]) }}" target="_blank" class="lms-action-btn lms-action-btn--view shrink-0">
                                {{ __('lms.common.download') }}
                            </a>
                        </div>
                    </div>
                @endif
            </x-lms-panel>
        </x-lms-section>

        @if($canSubmit)
            <x-lms-section :title="__('lms.assignment.submit_work')" icon="upload" compact>
                <x-lms-panel>
                    @if($assignment->deadline->isPast() && $assignment->late_submission_allowed)
                        <div class="mb-4">
                            <span class="lms-badge lms-badge--warning">{{ __('lms.assignment.late_allowed_badge') }}</span>
                        </div>
                    @endif

                    @if($submission)
                        @if($submission->isGraded())
                            <x-lms-notice tone="success" :title="__('lms.assignment.graded_message')">
                                @if($submission->feedback)
                                    {{ __('lms.assignment.feedback_label') }} {{ $submission->feedback }}
                                @endif
                            </x-lms-notice>
                        @else
                            <x-lms-notice tone="warning" icon="clipboard" :title="__('lms.assignment.submitted_on', ['date' => $submission->submitted_at->format('d M Y H:i')])">
                                @if($submission->status == 'late')
                                    <span class="lms-badge lms-badge--warning">{{ __('lms.grade.late') }}</span>
                                @endif
                                @if($assignment->deadline->isFuture())
                                    <p class="mt-1">{{ __('lms.assignment.edit_until_deadline') }}</p>
                                @elseif($assignment->late_submission_allowed)
                                    <p class="mt-1">{{ __('lms.assignment.edit_after_deadline_late') }}</p>
                                @endif
                            </x-lms-notice>
                            <div class="mt-4">
                                <a href="{{ route('peserta.submissions.edit', [$class, $assignment, $submission]) }}" class="lms-btn-secondary inline-flex items-center gap-2">
                                    <x-lms-icon name="edit" class="w-4 h-4" />
                                    {{ __('lms.assignment.edit_submission') }}
                                </a>
                            </div>
                        @endif
                    @else
                        <x-lms-notice tone="info" :title="$assignment->deadline->isFuture() ? __('lms.assignment.submit_before_deadline') : __('lms.assignment.submit_late_allowed')" />
                        <div class="mt-4">
                            <a href="{{ route('peserta.submissions.create', [$class, $assignment]) }}" class="lms-btn-primary inline-flex items-center gap-2">
                                <x-lms-icon name="upload" class="w-4 h-4" />
                                {{ __('lms.assignment.submit_btn') }}
                            </a>
                        </div>
                    @endif
                </x-lms-panel>
            </x-lms-section>
        @else
            <x-lms-section :title="__('lms.assignment.submission_closed')" icon="ban" compact>
                <x-lms-panel>
                    <div class="lms-empty-state-inline">
                        <span class="lms-empty-state-inline__icon"><x-lms-icon name="ban" class="w-6 h-6" /></span>
                        <h4 class="text-base font-bold text-red-800 mb-1">{{ __('lms.assignment.submission_not_available') }}</h4>
                        <p class="text-sm text-red-700">{{ __('lms.assignment.deadline_passed_no_late') }}</p>
                        @if($assignment->deadline)
                            <p class="text-xs text-red-600 mt-2">{{ __('lms.assignment.deadline_was', ['date' => $assignment->deadline->format('d M Y H:i')]) }}</p>
                        @endif
                    </div>
                </x-lms-panel>
            </x-lms-section>
        @endif

        @if($submission && ($submission->file_path || $submission->url || $submission->notes))
            <x-lms-section :title="__('lms.assignment.your_submission')" icon="document" compact>
                <x-slot:headerActions>
                    @if($submission->status == 'late')
                        <span class="lms-badge lms-badge--warning">{{ __('lms.grade.late') }}</span>
                    @endif
                </x-slot:headerActions>
                <x-lms-panel>
                    <div class="space-y-3">
                        @if($submission->file_path)
                            <div class="lms-attachment-row">
                                <span class="text-sm text-slate-700">{{ __('lms.assignment.uploaded_file') }}</span>
                                <a href="{{ route('secure.submissions.file', [$class, $assignment, $submission]) }}" target="_blank" class="lms-action-btn lms-action-btn--view">{{ __('lms.common.download') }}</a>
                            </div>
                        @endif
                        @if($submission->url)
                            <div class="lms-attachment-row">
                                <span class="text-sm text-slate-700">{{ __('lms.assignment.link_label') }}</span>
                                <a href="{{ $submission->url }}" target="_blank" class="text-sm text-brand-600 hover:underline break-all">{{ $submission->url }}</a>
                            </div>
                        @endif
                        @if($submission->notes)
                            <div class="lms-detail-row border-0 pt-0">
                                <span class="lms-detail-row__label">{{ __('lms.assignment.notes_label') }}</span>
                                <span class="lms-detail-row__value">{{ $submission->notes }}</span>
                            </div>
                        @endif
                        @if($submission->isGraded() && $submission->feedback)
                            <x-lms-notice tone="success" :title="__('lms.assignment.instructor_feedback')">
                                {{ $submission->feedback }}
                            </x-lms-notice>
                        @endif
                    </div>
                </x-lms-panel>
            </x-lms-section>
        @endif
    </x-lms-page-shell>
</x-app-layout>
