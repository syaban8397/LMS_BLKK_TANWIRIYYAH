<x-app-layout>
<div class="peserta-submission-create-wrapper lms-module-shell space-y-6">
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

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card :title="__('lms.assignment.submission_form')">
            <p class="text-xs text-slate-500 mb-4">{{ __('lms.assignment.submission_form_hint') }}</p>
            <form action="{{ route('peserta.submissions.store', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="form-group">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">📎 {{ __('lms.assignment.upload_file') }}</label>
                    <input type="file" name="file" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all cursor-pointer">
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">{{ __('lms.assignment.file_max_hint') }}</p>
                </div>

                <div class="form-group">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">🔗 {{ __('lms.assignment.url_label') }}</label>
                    <input type="url" name="url" placeholder="https://..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
                    @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">📝 {{ __('lms.attendance.notes_optional') }}</label>
                    <textarea name="notes" rows="4" placeholder="{{ __('lms.assignment.notes_ph') }}" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all"></textarea>
                </div>

                {{-- Deadline Warning --}}
                <div class="form-group bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                    <div class="flex items-start gap-2">
                        <span class="text-yellow-600 text-lg">⚠️</span>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">{{ __('lms.assignment.deadline_info') }}</p>
                            <p class="text-xs text-yellow-700 mt-0.5">{{ __('lms.assignment.submit_before') }} <span class="font-bold">{{ $assignment->deadline->format('d M Y H:i') }}</span></p>
                            <p class="text-xs text-yellow-600 mt-1">{{ __('lms.assignment.late_may_accepted') }}</p>
                        </div>
                    </div>
                </div>

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('peserta.assignments.show', [$class, $assignment])">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.assignment.submit_btn') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
