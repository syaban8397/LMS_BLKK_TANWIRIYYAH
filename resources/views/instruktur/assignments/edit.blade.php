<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.assignment.edit')"
            :subtitle="__('lms.assignment.edit_subtitle', ['title' => $class->title])"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.assignment.back_stream')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.assignment.edit')],
            ]"
        />

        <x-lms-validation-errors />

        @if($assignment->deadline->isPast())
            <x-lms-notice tone="warning" :title="__('lms.assignment.deadline_passed')">
                <p class="text-xs">
                    {{ __('lms.assignment.current_deadline', ['deadline' => $assignment->deadline->format('d M Y H:i')]) }}
                    @if($assignment->late_submission_allowed)
                        {{ __('lms.assignment.late_allowed_now') }}
                    @else
                        {{ __('lms.assignment.late_not_allowed_now') }}
                    @endif
                    {{ __('lms.assignment.change_setting_below') }}
                </p>
            </x-lms-notice>
        @endif

        <x-lms-section compact>
            <div class="lms-form-layout lms-form-layout--wide">
                <x-lms-form-card>
                    <form action="{{ route('instruktur.assignments.update', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.assignment.assignment_title') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.description') }} <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="5" required
                                      class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $assignment->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.assignment.attachment_optional') }}</label>
                            <div class="upload-area relative border-2 border-dashed border-slate-300 rounded-lg hover:border-blue-400 transition cursor-pointer bg-slate-50/50">
                                <input type="file" name="attachment" id="attachment_input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="text-center py-6 px-4">
                                    <x-lms-icon name="upload" class="w-8 h-8 mx-auto text-slate-400 mb-2" />
                                    <p class="text-sm text-slate-500">{{ __('lms.assignment.upload_new_file') }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ __('lms.assignment.file_types_hint') }}</p>
                                    <div id="file_name_display" class="mt-2 text-xs text-blue-600 font-medium hidden"></div>
                                </div>
                            </div>
                            @if($assignment->attachment)
                                <p class="text-xs text-green-600 mt-2">{{ __('lms.assignment.current_file', ['name' => basename($assignment->attachment)]) }}</p>
                            @endif
                            @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.due') }} <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="deadline" value="{{ old('deadline', $assignment->deadline->format('Y-m-d\TH:i')) }}" required
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                            @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-slate-400 mt-1">{{ __('lms.assignment.deadline_extend_edit_hint') }}</p>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="late_submission_allowed" value="0">
                            <label class="checkbox-label flex items-start gap-3 cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 transition-all">
                                <input type="checkbox" name="late_submission_allowed" value="1" {{ $assignment->late_submission_allowed ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mt-0.5">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-slate-700 block">{{ __('lms.assignment.allow_late') }}</span>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ __('lms.assignment.late_if_checked') }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ __('lms.assignment.late_if_unchecked') }}
                                    </p>
                                    @if($assignment->deadline->isPast())
                                        <p class="text-xs text-amber-600 mt-2 font-medium">
                                            {{ __('lms.assignment.deadline_passed_warn') }}
                                        </p>
                                    @endif
                                </div>
                            </label>
                        </div>

                        <x-lms-notice tone="info" :title="__('lms.assignment.info_title')">
                            {{ __('lms.assignment.info_future_only') }}
                        </x-lms-notice>

                        <div class="border-t border-slate-200 pt-4">
                            <form action="{{ route('instruktur.assignments.destroy', [$class, $assignment]) }}" method="POST"
                                  data-lms-confirm="{{ __('lms.assignment.delete_confirm') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="lms-btn-danger inline-flex items-center gap-1">
                                    <x-lms-icon name="trash" class="w-4 h-4" />
                                    {{ __('lms.assignment.delete_btn') }}
                                </button>
                            </form>
                        </div>

                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('instruktur.classes.stream', $class)">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.assignment.update_btn') }}</x-ds.button>
                        </x-lms-form-actions>
                    </form>
                </x-lms-form-card>
            </div>
        </x-lms-section>
    </x-lms-page-shell>

    <script>
        document.getElementById('attachment_input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const displayDiv = document.getElementById('file_name_display');
            if (file) {
                displayDiv.textContent = @json(__('lms.assignment.file_selected', ['name' => ''])) + file.name;
                displayDiv.classList.remove('hidden');
            } else {
                displayDiv.textContent = '';
                displayDiv.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
