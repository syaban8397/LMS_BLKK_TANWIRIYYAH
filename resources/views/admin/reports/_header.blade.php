@props(['title', 'description' => null, 'hideBack' => false, 'breadcrumbs' => []])

<x-lms-page-header
    :title="$title"
    :subtitle="$description"
    :back-url="$hideBack ? null : route('admin.reports.index')"
    :back-label="__('lms.report.back')"
    :breadcrumbs="$breadcrumbs"
/>
