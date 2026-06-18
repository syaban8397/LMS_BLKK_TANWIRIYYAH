<x-app-layout>
<div class="manage-wrapper lms-module-shell space-y-6">
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

        {{-- Enrolled Students Table --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-800">{{ __('lms.common.enrolled_students') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __('lms.common.total') }}: {{ $participants->total() }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">{{ __('lms.common.photo') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.common.name') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.auth.email') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('lms.common.phone') }}</th>
                            <th class="px-6 py-4 text-center">{{ __('lms.common.enrolled_at') }}</th>
                            <th class="px-6 py-4 text-center">{{ __('lms.common.status') }}</th>
                            <th class="px-6 py-4 text-center">{{ __('lms.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                            @php $student = $participant->participant; @endphp
                            <tr class="student-row border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <img src="{{ $student->profilePhotoUrl() }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="">
                                </td>
                                <td class="px-6 py-4 text-slate-800 font-medium">{{ $student->name }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">{{ $student->email }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">{{ $student->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-slate-700 text-sm">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
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
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('instruktur.classes.remove-student', [$class, $participant]) }}" method="POST" data-lms-confirm="{{ __('lms.common.remove_from_class') }}" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="lms-action-btn lms-action-btn--delete">{{ __('lms.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">{{ __('lms.common.no_participants_add_hint') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($participants->hasPages())
                <div class="px-6 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $participants->links() }}
                </div>
            @endif
        </div>

        {{-- Add Students Form --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">{{ __('lms.common.add_new_participant') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('lms.common.enrollment_current', ['current' => $class->participants->count(), 'quota' => $class->quota]) }}</p>
            </div>

            <div class="p-6">
                @if($availableStudents->count() == 0)
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2">👥</div>
                        <p class="text-slate-500">{{ __('lms.common.no_available_extended') }}</p>
                        <a href="{{ route('instruktur.classes.stream', $class) }}" class="lms-btn-secondary inline-block mt-4">{{ __('lms.common.back_to_class_btn') }}</a>
                    </div>
                @else
                    <form action="{{ route('instruktur.classes.add-student', $class) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">{{ __('lms.common.select_participant') }}</label>
                            <div class="bg-slate-50 rounded-xl p-4 space-y-2 max-h-96 overflow-y-auto border border-slate-200">
                                @foreach($availableStudents as $student)
                                    <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white transition cursor-pointer group">
                                        <input type="checkbox" name="participant_ids[]" value="{{ $student->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 transition group-hover:scale-105">
                                        <div class="flex items-center gap-3 flex-1">
                                            <img src="{{ $student->profilePhotoUrl() }}" class="w-8 h-8 rounded-full object-cover shadow-sm" alt="">
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">{{ $student->name }}</p>
                                                <p class="text-sm text-slate-500">{{ $student->email }}</p>
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                {{ $student->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('participant_ids')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                            <a href="{{ route('instruktur.classes.stream', $class) }}" class="lms-btn-secondary">{{ __('lms.cancel') }}</a>
                            <button type="submit" class="lms-btn-primary">{{ __('lms.common.add_selected') }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
