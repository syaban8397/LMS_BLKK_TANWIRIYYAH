<x-app-layout>
<div class="report-wrapper lms-module-shell space-y-6">
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

        <x-lms-session-flash />

        {{-- Report Card --}}
        <div class="report-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800">{{ __('lms.attendance.matrix_title') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('lms.attendance.matrix_hint') }}</p>
            </div>

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
                            <th class="px-3 py-3 text-center">✅</th>
                            <th class="px-3 py-3 text-center">📝</th>
                            <th class="px-3 py-3 text-center">🤒</th>
                            <th class="px-3 py-3 text-center">❌</th>
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
                                            'present'    => '✓',
                                            'permission' => '📝',
                                            'sick'       => '🤒',
                                            'absent'     => '✗',
                                            '-'          => '−'
                                        ];
                                    @endphp
                                    <td class="px-3 py-3 text-center">
                                        <span class="inline-block w-8 h-8 leading-8 rounded-full text-xs font-semibold {{ $colors[$status] }}">
                                            {{ $icons[$status] }}
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
        </div>
    </div>
</x-app-layout>
