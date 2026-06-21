<x-app-layout>
    <x-lms-page-shell class="peserta-submission-edit-wrapper">
        <x-lms-page-header
            :title="__('lms.assignment.edit_submission')"
            :subtitle="$assignment->title . ' — ' . $class->title"
            :back-url="route('peserta.assignments.show', [$class, $assignment])"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.assignment.list'), 'url' => route('peserta.assignments.index', $class)],
                ['label' => $assignment->title, 'url' => route('peserta.assignments.show', [$class, $assignment])],
                ['label' => __('lms.assignment.edit_submission')],
            ]"
        />

        <x-lms-validation-errors />

        <x-lms-section compact>
            <div class="lms-form-layout lms-form-layout--wide">
                <x-lms-form-card :title="__('lms.assignment.edit_submission')">
                    <p class="text-xs text-slate-500 mb-4">{{ __('lms.assignment.edit_submission_hint') }}</p>
                    <form action="{{ route('peserta.submissions.update', [$class, $assignment, $submission]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
                                <x-lms-icon name="upload" class="w-4 h-4" />
                                {{ __('lms.assignment.upload_new_file_label') }}
                            </label>
                            <input type="file" name="file" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all cursor-pointer">
                            @if($submission->file_path)
                                <p class="text-xs text-emerald-600 mt-1">{{ __('lms.assignment.current_file', ['name' => basename($submission->file_path)]) }}</p>
                            @endif
                            @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
                                <x-lms-icon name="link" class="w-4 h-4" />
                                {{ __('lms.assignment.url_label') }}
                            </label>
                            <input type="url" name="url" value="{{ old('url', $submission->url) }}" placeholder="https://..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
                            @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
                                <x-lms-icon name="edit" class="w-4 h-4" />
                                {{ __('lms.attendance.notes_optional') }}
                            </label>
                            <textarea name="notes" rows="4" placeholder="{{ __('lms.assignment.notes_ph_short') }}" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $submission->notes) }}</textarea>
                            @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <x-lms-notice tone="warning" icon="clock" :title="__('lms.assignment.deadline_reminder')">
                            <p class="text-xs">{{ __('lms.assignment.submission_deadline') }} <span class="font-bold">{{ $assignment->deadline->format('d M Y H:i') }}</span></p>
                            <p class="text-xs mt-1">{{ __('lms.assignment.edit_until_passes') }}</p>
                        </x-lms-notice>

                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('peserta.assignments.show', [$class, $assignment])">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.assignment.update_submission') }}</x-ds.button>
                        </x-lms-form-actions>
                    </form>

                    <div class="form-group mt-6 pt-4 border-t border-slate-200">
                        <form action="{{ route('peserta.submissions.destroy', [$class, $assignment, $submission]) }}" method="POST" data-lms-confirm="{{ __('lms.assignment.delete_submission_confirm') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-link text-red-600 text-sm hover:text-red-700 transition inline-flex items-center gap-1">
                                <x-lms-icon name="trash" class="w-4 h-4" />
                                {{ __('lms.assignment.delete_submission') }}
                            </button>
                        </form>
                    </div>
                </x-lms-form-card>
            </div>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
