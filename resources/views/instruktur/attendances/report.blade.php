<x-app-layout>
    <x-lms-page-shell class="report-wrapper">
        <x-lms-page-header
            :title="__('lms.attendance.report')"
            :subtitle="__('lms.attendance.report_subtitle', ['title' => $class->title])"
            :back-url="route('instruktur.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_sessions')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions'), 'url' => route('instruktur.attendances.index', $class)],
                ['label' => __('lms.attendance.report')],
            ]"
        />

        <x-lms-section :title="__('lms.attendance.matrix_title')" :description="__('lms.attendance.matrix_hint')" icon="clipboard" compact>
            <x-lms-panel flush pad="false">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-slate-50 text-slate-600 text-sm">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('lms.attendance.student') }}</th>
                                @foreach($meetings as $meeting)
                                    <th class="px-3 py-3 text-center">
                                        M{{ $meeting->meeting_number }}<br>
                                        <span class="text-xs">{{ $meeting->attendance_date->format('d/m') }}</span>
                                    </th>
                                @endforeach
                                <th class="px-3 py-3 text-center"><x-lms-icon name="check-circle" class="w-4 h-4 mx-auto" /></th>
                                <th class="px-3 py-3 text-center"><x-lms-icon name="edit" class="w-4 h-4 mx-auto" /></th>
                                <th class="px-3 py-3 text-center"><x-lms-icon name="warning" class="w-4 h-4 mx-auto" /></th>
                                <th class="px-3 py-3 text-center"><x-lms-icon name="ban" class="w-4 h-4 mx-auto" /></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceMatrix as $studentId => $data)
                                <tr class="report-row border-t border-slate-100 hover:bg-slate-50 transition">
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-slate-800">{{ $data['name'] }}</p>
                                    </td>
                                    @foreach($meetings as $meeting)
                                        @php
                                            $status = $data['attendances'][$meeting->meeting_number] ?? '-';
                                            $colors = [
                                                'present'    => 'bg-green-100 text-green-700',
                                                'permission' => 'bg-yellow-100 text-yellow-700',
                                                'sick'       => 'bg-orange-100 text-orange-700',
                                                'absent'     => 'bg-red-100 text-red-700',
                                                '-'          => 'bg-slate-100 text-slate-400'
                                            ];
                                            $icons = [
                                                'present'    => 'check-circle',
                                                'permission' => 'edit',
                                                'sick'       => 'warning',
                                                'absent'     => 'ban',
                                            ];
                                        @endphp
                                        <td class="px-3 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-semibold {{ $colors[$status] }}">
                                                @if($status !== '-')
                                                    <x-lms-icon :name="$icons[$status]" class="w-4 h-4" />
                                                @else
                                                    &minus;
                                                @endif
                                            </span>
                                        </td>
                                    @endforeach
                                    <td class="px-3 py-3 text-center font-bold text-green-700">{{ $data['present_count'] }}</td>
                                    <td class="px-3 py-3 text-center font-bold text-yellow-700">{{ $data['permission_count'] }}</td>
                                    <td class="px-3 py-3 text-center font-bold text-orange-700">{{ $data['sick_count'] }}</td>
                                    <td class="px-3 py-3 text-center font-bold text-red-700">{{ $data['absent_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
