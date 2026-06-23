<x-app-layout>
    <x-lms-page-shell class="peserta-submission-create-wrapper">
        <x-lms-page-header
            :title="__('lms.assignment.submit_work')"
            :subtitle="$assignment->title . ' — ' . $class->title"
            :back-url="route('peserta.assignments.show', [$class, $assignment])"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.assignment.list'), 'url' => route('peserta.assignments.index', $class)],
                ['label' => $assignment->title, 'url' => route('peserta.assignments.show', [$class, $assignment])],
                ['label' => __('lms.assignment.submit_work')],
            ]"
        />

        <x-lms-validation-errors />

        <x-lms-section compact>
            <div class="lms-form-layout lms-form-layout--wide">
                <x-lms-form-card :title="__('lms.assignment.submission_form')">
                    <p class="text-xs text-slate-500 mb-4">{{ __('lms.assignment.submission_form_hint') }}</p>
                    <form action="{{ route('peserta.submissions.store', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        @include('peserta.submissions.partials.form-fields', ['assignment' => $assignment, 'submission' => null])

                        <x-lms-notice tone="warning" :title="__('lms.assignment.deadline_info')">
                            <p class="text-xs">{{ __('lms.assignment.submit_before') }} <span class="font-bold">{{ $assignment->deadline->format('d M Y H:i') }}</span></p>
                            <p class="text-xs mt-1">{{ __('lms.assignment.late_may_accepted') }}</p>
                        </x-lms-notice>

                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('peserta.assignments.show', [$class, $assignment])">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.assignment.submit_btn') }}</x-ds.button>
                        </x-lms-form-actions>
                    </form>
                </x-lms-form-card>
            </div>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
