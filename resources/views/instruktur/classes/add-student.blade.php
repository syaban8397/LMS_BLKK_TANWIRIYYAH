<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.common.manage_participants')"
            :subtitle="$class->title . ' • ' . __('lms.common.manage_participants_desc')"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.common.manage_participants')],
            ]"
        />

        <x-lms-session-flash />

        <x-lms-section
            :title="__('lms.common.enrolled_students')"
            :description="__('lms.common.total') . ': ' . $participants->total()"
            icon="users"
            compact
        >
            <x-lms-data-table :paginator="$participants" :skeleton-cols="7">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.photo') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.name') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.auth.email') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.phone') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.enrolled_at') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                    </tr>
                </x-slot:head>

                @forelse($participants as $participant)
                    @php $student = $participant->participant; @endphp
                    <tr>
                        <td>
                            <img src="{{ $student->profilePhotoUrl() }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="">
                        </td>
                        <td class="font-medium text-slate-800 dark:text-slate-100">{{ $student->name }}</td>
                        <td class="text-slate-600 dark:text-slate-300 text-sm">{{ $student->email }}</td>
                        <td class="text-slate-600 dark:text-slate-300 text-sm">{{ $student->phone ?? '-' }}</td>
                        <td class="text-center text-slate-600 dark:text-slate-300 text-sm">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('instruktur.classes.update-student-status', [$class, $participant]) }}" method="POST" class="inline-block">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 px-2 py-1 bg-white transition hover:border-blue-400">
                                    <option value="active" {{ $participant->status == 'active' ? 'selected' : '' }}>{{ __('lms.active') }}</option>
                                    <option value="completed" {{ $participant->status == 'completed' ? 'selected' : '' }}>{{ __('lms.common.completed') }}</option>
                                    <option value="dropped" {{ $participant->status == 'dropped' ? 'selected' : '' }}>{{ __('lms.common.dropped') }}</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('instruktur.classes.remove-student', [$class, $participant]) }}" method="POST" data-lms-confirm="{{ __('lms.common.remove_from_class') }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="lms-action-btn lms-action-btn--delete">{{ __('lms.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="7" :message="__('lms.common.no_participants_add_hint')" icon="👥" />
                @endforelse
            </x-lms-data-table>
        </x-lms-section>

        <x-lms-section
            :title="__('lms.common.add_new_participant')"
            :description="__('lms.common.enrollment_current', ['current' => $class->participants->count(), 'quota' => $class->quota])"
            icon="user-plus"
            compact
        >
            <x-lms-panel>
                @if($availableStudents->count() == 0)
                    <x-lms-empty-state icon="👥" :message="__('lms.common.no_available_extended')">
                        <x-slot:actions>
                            <a href="{{ route('instruktur.classes.stream', $class) }}" class="lms-btn-secondary">{{ __('lms.common.back_to_class_btn') }}</a>
                        </x-slot:actions>
                    </x-lms-empty-state>
                @else
                    <form action="{{ route('instruktur.classes.add-student', $class) }}" method="POST" class="lms-form-layout">
                        @csrf
                        <x-lms-form-card :title="__('lms.common.select_participant')" icon="users">
                            <div class="bg-slate-50 rounded-xl p-4 space-y-2 max-h-96 overflow-y-auto border border-slate-200">
                                @foreach($availableStudents as $student)
                                    <label class="lms-list-item cursor-pointer hover:bg-white">
                                        <input type="checkbox" name="participant_ids[]" value="{{ $student->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 shrink-0">
                                        <img src="{{ $student->profilePhotoUrl() }}" class="w-8 h-8 rounded-full object-cover shadow-sm shrink-0" alt="">
                                        <div class="min-w-0 flex-1">
                                            <p class="lms-list-item__title">{{ $student->name }}</p>
                                            <p class="lms-list-item__meta">{{ $student->email }} · {{ $student->phone ?? '-' }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('participant_ids')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror

                            <x-lms-form-actions>
                                <a href="{{ route('instruktur.classes.stream', $class) }}" class="lms-btn-secondary">{{ __('lms.cancel') }}</a>
                                <button type="submit" class="lms-btn-primary">{{ __('lms.common.add_selected') }}</button>
                            </x-lms-form-actions>
                        </x-lms-form-card>
                    </form>
                @endif
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
