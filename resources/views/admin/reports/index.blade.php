<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.index_title'),
            'description' => __('lms.report.index_desc'),
            'hideBack' => true,
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title')],
            ],
        ])

        <div class="lms-report-index-grid">
            @foreach([
                ['route' => 'admin.reports.participants', 'icon' => 'users', 'title' => __('lms.report.participants'), 'desc' => __('lms.report.participants_card_desc')],
                ['route' => 'admin.reports.instructors', 'icon' => 'academic-cap', 'title' => __('lms.report.instructors'), 'desc' => __('lms.report.instructors_card_desc')],
                ['route' => 'admin.reports.classes', 'icon' => 'building', 'title' => __('lms.report.classes'), 'desc' => __('lms.report.classes_card_desc')],
                ['route' => 'admin.reports.attendance', 'icon' => 'calendar', 'title' => __('lms.report.attendance'), 'desc' => __('lms.report.attendance_card_desc')],
                ['route' => 'admin.reports.grades', 'icon' => 'clipboard', 'title' => __('lms.report.grades'), 'desc' => __('lms.report.grades_card_desc')],
                ['route' => 'admin.reports.certificates', 'icon' => 'certificate', 'title' => __('lms.report.certificates'), 'desc' => __('lms.report.certificates_card_desc')],
            ] as $item)
                <a href="{{ route($item['route']) }}" class="lms-report-index-card">
                    <x-lms-panel>
                        <div class="flex items-start gap-3">
                            <span class="lms-section__icon shrink-0" aria-hidden="true">
                                <x-lms-icon :name="$item['icon']" class="w-4 h-4" />
                            </span>
                            <div>
                                <h2 class="lms-report-index-card__title">{{ $item['title'] }}</h2>
                                <p class="lms-report-index-card__desc">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    </x-lms-panel>
                </a>
            @endforeach
        </div>
    </x-lms-page-shell>
</x-app-layout>
