<x-app-layout>

    <div class="lms-page-shell space-y-5">

        @include('admin.reports._header', [

            'title' => __('lms.report.grades'),

            'description' => __('lms.report.grades_desc'),

        ])



        <div class="flex justify-end">

            <a href="{{ route('admin.reports.grades.export') }}" class="lms-btn-success btn-3d">

                {{ __('lms.export_excel') }}

            </a>

        </div>



        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">

            <table class="w-full text-sm min-w-[1200px]">

                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">

                    <tr>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.no') }}</th>

                        @include('admin.reports._participant-minimal-head')

                        <th class="px-3 py-3 text-left">{{ __('lms.common.code') }}</th>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.class_name') }}</th>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.program') }}</th>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.instructor') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.assignment_score') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.attendance_score') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.final_score') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.graduation_status') }}</th>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.feedback') }}</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($grades as $index => $grade)

                        <tr class="hover:bg-slate-50">

                            <td class="px-3 py-3 text-slate-500">{{ $index + 1 }}</td>

                            @if($grade->participant)

                                @include('admin.reports._participant-minimal-row', ['user' => $grade->participant])

                            @else

                                @for($i = 0; $i < 3; $i++)<td class="px-3 py-3">-</td>@endfor

                            @endif

                            <td class="px-3 py-3 text-slate-600 font-mono text-xs">{{ $grade->class->code ?? '-' }}</td>

                            <td class="px-3 py-3 text-slate-600">{{ $grade->class->title ?? '-' }}</td>

                            <td class="px-3 py-3 text-slate-600">{{ $grade->class->program->name ?? '-' }}</td>

                            <td class="px-3 py-3 text-slate-600">{{ $grade->class->instructor->name ?? '-' }}</td>

                            <td class="px-3 py-3 text-center">{{ $grade->assignment_score ?? '-' }}</td>

                            <td class="px-3 py-3 text-center">{{ $grade->attendance_score ?? '-' }}</td>

                            <td class="px-3 py-3 text-center font-semibold">{{ $grade->final_score ?? '-' }}</td>

                            <td class="px-3 py-3 text-center text-xs">{{ $grade->status ?? '-' }}</td>

                            <td class="px-3 py-3 text-slate-600">{{ $grade->feedback ?? '-' }}</td>

                        </tr>

                    @empty

                        <tr><td colspan="13" class="py-10 text-center text-slate-400">{{ __('lms.report.no_grades') }}</td></tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>

