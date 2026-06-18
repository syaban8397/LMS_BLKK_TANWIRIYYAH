<x-app-layout>

    <div class="lms-page-shell lms-module-shell lms-report-shell space-y-5">

        @include('admin.reports._header', [
            'title' => __('lms.report.index_title'),
            'description' => __('lms.report.index_desc'),
            'hideBack' => true,
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title')],
            ],
        ])

        <x-lms-session-flash />

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">

            @foreach([
                ['route' => 'admin.reports.participants', 'icon' => '👥', 'title' => __('lms.report.participants'), 'desc' => __('lms.report.participants_card_desc')],
                ['route' => 'admin.reports.instructors', 'icon' => '👨‍🏫', 'title' => __('lms.report.instructors'), 'desc' => __('lms.report.instructors_card_desc')],
                ['route' => 'admin.reports.classes', 'icon' => '🏫', 'title' => __('lms.report.classes'), 'desc' => __('lms.report.classes_card_desc')],
                ['route' => 'admin.reports.attendance', 'icon' => '📅', 'title' => __('lms.report.attendance'), 'desc' => __('lms.report.attendance_card_desc')],
                ['route' => 'admin.reports.grades', 'icon' => '📝', 'title' => __('lms.report.grades'), 'desc' => __('lms.report.grades_card_desc')],
                ['route' => 'admin.reports.certificates', 'icon' => '📜', 'title' => __('lms.report.certificates'), 'desc' => __('lms.report.certificates_card_desc')],
            ] as $item)
                <a href="{{ route($item['route']) }}"
                   class="block bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition">
                    <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                    <h2 class="font-semibold text-slate-800">{{ $item['title'] }}</h2>
                    <p class="text-xs text-slate-500 mt-1">{{ $item['desc'] }}</p>
                </a>
            @endforeach

        </div>

    </div>

</x-app-layout>
