<x-app-layout>
    <x-lms-page-shell>
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

        @if($assignments->count() > 0)
        <x-lms-section :title="__('lms.assignment.list')" :description="__('lms.assignment.total_meta', ['total' => $assignments->total()])" icon="clipboard" compact>
            <x-lms-panel>
                @foreach($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                        $statusText = $submission ? ($submission->isGraded() ? __('lms.common.graded') : __('lms.common.submitted')) : __('lms.common.not_submitted');
                        $statusBadge = $submission
                            ? ($submission->isGraded() ? 'lms-badge--success' : 'lms-badge--warning')
                            : 'lms-badge--danger';
                        $isDeadlinePassed = $assignment->deadline->isPast();
                    @endphp
                    <div class="lms-list-item">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="lms-list-item__title">{{ $assignment->title }}</h3>
                                <span class="lms-badge {{ $statusBadge }}">{{ $statusText }}</span>
                                @if($isDeadlinePassed)
                                    <span class="lms-badge lms-badge--danger inline-flex items-center gap-1">
                                        <x-lms-icon name="clock" class="w-3 h-3" />
                                        {{ __('lms.common.ended') }}
                                    </span>
                                @endif
                            </div>
                            <p class="lms-list-item__body">{{ $assignment->description }}</p>
                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1">
                                <x-lms-meta-chip icon="calendar">{{ __('lms.common.due_label') }} {{ $assignment->deadline->format('d M Y H:i') }}</x-lms-meta-chip>
                                <x-lms-meta-chip icon="document">{{ $assignment->attachment ? __('lms.assignment.attachment_available') : __('lms.assignment.no_file') }}</x-lms-meta-chip>
                            </div>
                        </div>
                        <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="lms-btn-primary text-sm shrink-0">{{ __('lms.view') }}</a>
                    </div>
                @endforeach
            </x-lms-panel>
            <x-lms-pagination :paginator="$assignments" />
        </x-lms-section>
        @else
        <x-lms-section :title="__('lms.assignment.list')" compact>
            <x-lms-panel>
                <x-lms-empty-state icon="clipboard" :title="__('lms.assignment.no_assignments_available')" />
            </x-lms-panel>
        </x-lms-section>
        @endif
    </x-lms-page-shell>
</x-app-layout>
