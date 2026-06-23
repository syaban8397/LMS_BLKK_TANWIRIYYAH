<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.common.subtitle_code_instructor', ['code' => $class->code, 'instructor' => $class->instructor->name])"
            :back-url="route('instruktur.classes.index')"
            :breadcrumbs="[
                ['label' => __('lms.nav.classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title],
            ]"
        />

        <div class="lms-stream-layout">
            <div class="lms-stream-sidebar space-y-5">
                <x-lms-section :title="__('lms.common.class_info')" icon="clipboard" compact>
                    <x-lms-panel>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.report.program') }}</span><span class="font-medium">{{ $class->program->name }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.common.capacity') }}</span><span class="font-medium"><span class="text-emerald-600">{{ $class->participants_count }}</span> / {{ $class->quota }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.common.period') }}</span><span class="font-medium">{{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.common.status') }}</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $class->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                    @switch($class->status)
                                        @case('draft') {{ __('lms.common.draft') }} @break
                                        @case('active') {{ __('lms.active') }} @break
                                        @case('completed') {{ __('lms.common.completed') }} @break
                                        @case('cancelled') {{ __('lms.common.cancelled') }} @break
                                        @default {{ ucfirst($class->status) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="pt-2 border-t"><span class="text-slate-500 text-xs">{{ __('lms.common.description') }}</span><p class="text-slate-600 mt-1 text-sm">{{ $class->description ?: __('lms.common.no_description') }}</p></div>
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.quick_actions')" icon="bolt" compact>
                    <x-lms-panel>
                        <div class="lms-quick-grid">
                            <a href="{{ route('instruktur.materials.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="book" /></span>
                                <span>{{ __('lms.common.all_materials') }}</span>
                            </a>
                            <a href="{{ route('instruktur.assignments.create', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="plus" /></span>
                                <span>{{ __('lms.common.new_assignment') }}</span>
                            </a>
                            <a href="{{ route('instruktur.attendances.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="calendar" /></span>
                                <span>{{ __('lms.common.manage_attendance') }}</span>
                            </a>
                            <a href="{{ route('instruktur.classes.add-student', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="users" /></span>
                                <span>{{ __('lms.common.manage_students') }}</span>
                            </a>
                        </div>
                    </x-lms-panel>
                </x-lms-section>
            </div>

            <div class="lms-stream-main space-y-5">
                <x-lms-section :title="__('lms.common.post_announcement')" icon="megaphone" compact>
                    <x-lms-panel>
                        <form action="{{ route('instruktur.announcements.store', $class) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="text" name="title" placeholder="{{ __('lms.common.announcement_title_ph') }}" required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 text-sm px-3 py-2">
                            <textarea name="description" rows="2" placeholder="{{ __('lms.common.announcement_body_ph') }}" required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 text-sm px-3 py-2"></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="lms-btn-primary">{{ __('lms.common.post_announcement') }}</button>
                            </div>
                        </form>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section compact>
                    <x-lms-panel>
                        <div class="lms-quick-grid lms-quick-grid--3">
                            <a href="{{ route('instruktur.materials.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="document" /></span>
                                <span>
                                    <span class="lms-quick-link__title">{{ __('lms.common.add_material') }}</span>
                                    <span class="lms-quick-link__desc">{{ __('lms.common.upload_resources') }}</span>
                                </span>
                            </a>
                            <a href="{{ route('instruktur.assignments.create', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="edit" /></span>
                                <span>
                                    <span class="lms-quick-link__title">{{ __('lms.common.new_assignment') }}</span>
                                    <span class="lms-quick-link__desc">{{ __('lms.common.create_tasks') }}</span>
                                </span>
                            </a>
                            <a href="{{ route('instruktur.attendances.index', $class) }}" class="lms-quick-link">
                                <span class="lms-quick-link__icon"><x-lms-icon name="calendar" /></span>
                                <span>
                                    <span class="lms-quick-link__title">{{ __('lms.common.take_attendance') }}</span>
                                    <span class="lms-quick-link__desc">{{ __('lms.common.record_presence') }}</span>
                                </span>
                            </a>
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.class_stream')" icon="megaphone" compact>
                    <div class="lms-timeline space-y-4">
                        @forelse($announcements as $announcement)
                        <x-lms-panel class="lms-timeline-item lms-timeline-item--announcement" id="announcement-{{ $announcement->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3">
                                    <div class="lms-avatar-badge"><x-lms-icon name="megaphone" /></div>
                                    <div><p class="font-semibold text-slate-800">{{ $announcement->creator?->name }}</p><p class="text-xs text-slate-400">{{ $announcement->created_at->diffForHumans() }}</p></div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" data-announcement-edit="{{ $announcement->id }}" class="lms-action-btn lms-action-btn--edit">{{ __('lms.edit') }}</button>
                                    <form action="{{ route('instruktur.announcements.destroy', [$class, $announcement]) }}" method="POST" data-lms-confirm="{{ __('lms.common.confirm_delete') }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="lms-action-btn lms-action-btn--delete">{{ __('lms.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                            <div class="announcement-view-{{ $announcement->id }} mt-3">
                                <h4 class="font-bold text-slate-800">{{ $announcement->title }}</h4>
                                <p class="text-slate-600 text-sm mt-1 whitespace-pre-line">{{ $announcement->description }}</p>
                            </div>
                            <div class="announcement-edit-{{ $announcement->id }} mt-3" style="display:none;">
                                <form action="{{ route('instruktur.announcements.update', [$class, $announcement]) }}" method="POST" class="space-y-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="title" value="{{ $announcement->title }}" class="input-3d w-full rounded-lg border-slate-200 text-sm px-3 py-1.5">
                                    <textarea name="description" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-sm px-3 py-1.5">{{ $announcement->description }}</textarea>
                                    <div class="flex gap-2"><button type="submit" class="lms-action-btn lms-action-btn--approve">{{ __('lms.save') }}</button><button type="button" data-announcement-cancel="{{ $announcement->id }}" class="lms-action-btn lms-action-btn--reject">{{ __('lms.cancel') }}</button></div>
                                </form>
                            </div>
                        </x-lms-panel>
                        @empty
                        <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_announcements') }}</x-lms-panel>
                        @endforelse

                        @forelse($materials as $material)
                        <x-lms-panel class="lms-timeline-item lms-timeline-item--material">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3"><div class="lms-avatar-badge"><x-lms-icon name="book" /></div><div><p class="font-semibold text-slate-800">{{ $material->creator?->name }}</p><p class="text-xs text-slate-400">{{ __('lms.common.meeting') }} {{ $material->meeting_number }} &bull; {{ $material->created_at->diffForHumans() }}</p></div></div>
                                <div class="flex gap-2"><a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="lms-action-btn lms-action-btn--view">{{ __('lms.view') }}</a><a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="lms-action-btn lms-action-btn--edit">{{ __('lms.edit') }}</a></div>
                            </div>
                            <h4 class="font-bold text-slate-800 mt-3">{{ $material->title }}</h4>
                            @if($material->description)<p class="text-slate-600 text-sm mt-1">{{ $material->description }}</p>@endif
                            <div class="flex gap-2 mt-2">
                                @if($material->file_path)
                                    <span class="lms-badge lms-badge--info inline-flex items-center gap-1"><x-lms-icon name="document" class="w-3 h-3" /> {{ __('lms.common.attachment') }}</span>
                                @endif
                                @if($material->youtube_url)
                                    <span class="lms-badge lms-badge--danger inline-flex items-center gap-1"><x-lms-icon name="film" class="w-3 h-3" /> {{ __('lms.material.youtube') }}</span>
                                @endif
                            </div>
                        </x-lms-panel>
                        @empty
                        <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_materials') }}</x-lms-panel>
                        @endforelse

                        @forelse($assignments as $assignment)
                        @php $submittedCount = $assignment->submissions_count; $gradedCount = $assignment->graded_submissions_count; @endphp
                        <x-lms-panel class="lms-timeline-item lms-timeline-item--assignment">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3"><div class="lms-avatar-badge"><x-lms-icon name="clipboard" /></div><div><p class="font-semibold text-slate-800">{{ $assignment->creator?->name }}</p><p class="text-xs text-slate-400">{{ __('lms.common.due_label') }} {{ $assignment->deadline->format('d M Y H:i') }}</p></div></div>
                                <div class="flex gap-2"><a href="{{ route('instruktur.assignments.edit', [$class, $assignment]) }}" class="lms-action-btn lms-action-btn--edit">{{ __('lms.edit') }}</a><a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="lms-action-btn !bg-purple-600 hover:!bg-purple-700">{{ __('lms.common.submissions') }} ({{ $submittedCount }})</a><form action="{{ route('instruktur.assignments.destroy', [$class, $assignment]) }}" method="POST" data-lms-confirm="{{ __('lms.common.confirm_delete') }}" class="inline">@csrf @method('DELETE')<button type="submit" class="lms-action-btn lms-action-btn--delete">{{ __('lms.delete') }}</button></form></div>
                            </div>
                            <h4 class="font-bold text-slate-800 mt-3">{{ $assignment->title }}</h4>
                            <p class="text-slate-600 text-sm mt-1">{{ $assignment->description }}</p>
                            @if($assignment->attachment)
                                <a href="{{ route('secure.assignments.attachment', [$class, $assignment]) }}" class="text-xs text-brand-600 mt-2 inline-flex items-center gap-1 hover:underline">
                                    <x-lms-icon name="document" class="w-3 h-3" /> {{ __('lms.common.download') }}
                                </a>
                            @endif
                            @if($submittedCount > 0)
                            <div class="mt-3 pt-2 border-t">
                                <x-lms-progress
                                    tone="purple"
                                    :label="__('lms.common.grading_progress')"
                                    :value="$gradedCount"
                                    :max="$submittedCount"
                                />
                            </div>
                            @endif
                        </x-lms-panel>
                        @empty
                        <x-lms-panel class="lms-timeline-item text-center text-slate-400">{{ __('lms.common.no_assignments') }}</x-lms-panel>
                        @endforelse
                    </div>
                </x-lms-section>
            </div>
        </div>
    </x-lms-page-shell>

    <script>
        function showEditForm(id) {
            document.querySelector('.announcement-view-' + id).style.display = 'none';
            document.querySelector('.announcement-edit-' + id).style.display = 'block';
        }

        function cancelEdit(id) {
            document.querySelector('.announcement-view-' + id).style.display = 'block';
            document.querySelector('.announcement-edit-' + id).style.display = 'none';
        }

        document.querySelectorAll('[data-announcement-edit]').forEach(function (button) {
            button.addEventListener('click', function () {
                showEditForm(button.getAttribute('data-announcement-edit'));
            });
        });

        document.querySelectorAll('[data-announcement-cancel]').forEach(function (button) {
            button.addEventListener('click', function () {
                cancelEdit(button.getAttribute('data-announcement-cancel'));
            });
        });
    </script>
</x-app-layout>
