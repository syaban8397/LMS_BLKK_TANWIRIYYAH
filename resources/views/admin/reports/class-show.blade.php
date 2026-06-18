<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.report.classes') . ' — ' . $class->title"
            :subtitle="$class->program->name . ' · ' . __('lms.report.instructor') . ': ' . $class->instructor->name . ' · ' . $class->code"
            :back-url="route('admin.reports.classes')"
            :back-label="__('lms.report.back')"
        >
            <x-slot:actions>
                <a href="{{ route('admin.reports.classes.export-class', $class) }}" class="lms-btn-success btn-3d">{{ __('lms.export_excel') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm min-w-[1600px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-3 py-3 text-left">{{ __('lms.report.no') }}</th>
                        @include('admin.reports._user-columns-head')
                        <th class="px-3 py-3 text-center">{{ __('lms.report.attendance_short') }}</th>
                        <th class="px-3 py-3 text-center">{{ __('lms.report.submission_col') }}</th>
                        <th class="px-3 py-3 text-center">{{ __('lms.report.graduation_status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $index => $row)
                        @php $status = $row['final_grade']?->status; @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3 text-slate-500">{{ $index + 1 }}</td>
                            @include('admin.reports._user-columns-row', ['user' => $row['participant']])
                            <td class="px-3 py-3 text-center">
                                <span class="font-semibold text-blue-700">{{ $row['attendance_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_meetings'] }}</span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <span class="font-semibold text-purple-700">{{ $row['submission_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_assignments'] }}</span>
                            </td>
                            <td class="px-3 py-3 text-center text-xs font-medium">{{ $status ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="17" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
