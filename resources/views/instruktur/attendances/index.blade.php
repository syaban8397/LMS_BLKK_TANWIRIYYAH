<x-app-layout>
    <div class="attendance-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.attendance.sessions')"
            :subtitle="$class->title . ' • ' . __('lms.attendance.manage_per_meeting')"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions')],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.attendances.create', $class) }}" class="lms-btn-primary">+ {{ __('lms.attendance.new_session') }}</a>
                <a href="{{ route('instruktur.attendances.report', $class) }}" class="lms-btn-primary !bg-green-600 hover:!bg-green-700">📊 {{ __('lms.attendance.report') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        <x-lms-card class="table-card p-0" :title="__('lms.attendance.sessions')" :meta="__('lms.attendance.index_table_meta')">
            <x-lms-data-table :skeleton-cols="8">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.meeting') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.attendance.date') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">✅ {{ __('lms.report.present') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">📝 {{ __('lms.report.permission') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">🤒 {{ __('lms.report.sick') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">❌ {{ __('lms.report.absent') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.total') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                    </tr>
                </x-slot:head>

                @forelse($meetings as $meeting)
                    @php
                        $stats = \App\Models\Attendance::where('class_id', $class->id)
                            ->where('meeting_number', $meeting->meeting_number)
                            ->get();
                        $present    = $stats->where('status','present')->count();
                        $permission = $stats->where('status','permission')->count();
                        $sick       = $stats->where('status','sick')->count();
                        $absent     = $stats->where('status','absent')->count();
                        $total      = $present + $permission + $sick + $absent;
                    @endphp
                    <tr class="attendance-row transition">
                        <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-100">{{ __('lms.common.meeting') }} {{ $meeting->meeting_number }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($meeting->attendance_date)->format('d F Y H:i') }}</td>
                        <td class="px-6 py-4 text-center text-green-600 dark:text-green-400 font-semibold">{{ $present }}</td>
                        <td class="px-6 py-4 text-center text-yellow-600 dark:text-yellow-400 font-semibold">{{ $permission }}</td>
                        <td class="px-6 py-4 text-center text-orange-600 dark:text-orange-400 font-semibold">{{ $sick }}</td>
                        <td class="px-6 py-4 text-center text-red-600 dark:text-red-400 font-semibold">{{ $absent }}</td>
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ $total }}</td>
                        <td class="px-6 py-4 text-center">
                            <x-lms-row-actions>
                                <x-lms-action-btn variant="view" :href="route('instruktur.attendances.show', [$class, $meeting->meeting_number])">{{ __('lms.view') }}</x-lms-action-btn>
                                <x-lms-action-btn variant="edit" :href="route('instruktur.attendances.edit', [$class, $meeting->meeting_number])">{{ __('lms.edit') }}</x-lms-action-btn>
                                <form action="{{ route('instruktur.attendances.destroy', [$class, $meeting->meeting_number]) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.attendance.delete_session_confirm')">{{ __('lms.delete') }}</x-lms-action-btn>
                                </form>
                            </x-lms-row-actions>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="8" :message="__('lms.attendance.no_sessions')" icon="📅">
                        <x-slot:actions>
                            <a href="{{ route('instruktur.attendances.create', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">{{ __('lms.attendance.create_first') }}</a>
                        </x-slot:actions>
                    </x-lms-table-empty>
                @endforelse
            </x-lms-data-table>
        </x-lms-card>
    </div>
</x-app-layout>
