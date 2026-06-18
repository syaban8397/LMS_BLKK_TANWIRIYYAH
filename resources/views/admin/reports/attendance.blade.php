<x-app-layout>

    <div class="lms-page-shell space-y-5">

        @include('admin.reports._header', [

            'title' => __('lms.report.attendance'),

            'description' => __('lms.report.attendance_desc'),

        ])



        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">

                    <tr>

                        <th class="px-4 py-3 text-left">{{ __('lms.report.class_name') }}</th>

                        <th class="px-4 py-3 text-left">{{ __('lms.report.program') }}</th>

                        <th class="px-4 py-3 text-left">{{ __('lms.report.instructor') }}</th>

                        <th class="px-4 py-3 text-center">{{ __('lms.report.action') }}</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($classes as $class)

                        <tr class="hover:bg-slate-50">

                            <td class="px-4 py-3">

                                <div class="font-semibold text-slate-800">{{ $class->title }}</div>

                                <div class="text-xs text-slate-500">{{ $class->code }}</div>

                            </td>

                            <td class="px-4 py-3 text-slate-600">{{ $class->program->name }}</td>

                            <td class="px-4 py-3 text-slate-600">{{ $class->instructor->name }}</td>

                            <td class="px-4 py-3 text-center">

                                <a href="{{ route('admin.reports.attendance.show', $class) }}"

                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">{{ __('lms.report.view_summary') }}</a>

                            </td>

                        </tr>

                    @empty

                        <tr><td colspan="4" class="py-10 text-center text-slate-400">{{ __('lms.report.no_classes') }}</td></tr>

                    @endforelse

                </tbody>

            </table>

            @if($classes->hasPages())

                <div class="px-4 py-3 border-t">{{ $classes->links() }}</div>

            @endif

        </div>

    </div>

</x-app-layout>

