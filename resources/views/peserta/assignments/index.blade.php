<x-app-layout>
    <div class="peserta-assignments-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.assignment.list')"
            :subtitle="$class->title"
            :back-url="route('peserta.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.assignment.list')],
            ]"
        />

        <x-lms-session-flash />

        <x-lms-list-card
            class="assignments-card"
            :title="__('lms.assignment.list')"
            :meta="__('lms.assignment.total_meta', ['total' => $assignments->total()])"
            :paginator="$assignments"
            emptyIcon="clipboard"
            :emptyTitle="__('lms.assignment.no_assignments_available')"
        >
            <div class="divide-y divide-slate-100 dark:divide-slate-700/55">
                @foreach($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                        $statusText = $submission ? ($submission->isGraded() ? __('lms.common.graded') : __('lms.common.submitted')) : __('lms.common.not_submitted');
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
                                        <span class="lms-badge lms-badge--danger">⏰ {{ __('lms.common.ended') }}</span>
                                    @endif
                                </div>
                                <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2">{{ $assignment->description }}</p>
                                <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-500 dark:text-slate-400">
                                    <span>📅 {{ __('lms.common.due_label') }} {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                    <span>📎 {{ $assignment->attachment ? __('lms.assignment.attachment_available') : __('lms.assignment.no_file') }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="lms-btn-primary">{{ __('lms.view') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-lms-list-card>
    </div>
</x-app-layout>
