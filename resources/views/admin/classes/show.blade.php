<x-app-layout>
    <div class="lms-module-shell space-y-5">
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.admin_page.class_code_subtitle', ['code' => $class->code])"
            :back-url="route('admin.classes.index')"
            :breadcrumbs="[
                ['label' => __('lms.nav.classes'), 'url' => route('admin.classes.index')],
                ['label' => $class->title],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.certificates.show', $class) }}" class="lms-btn-warning">{{ __('lms.admin_page.certificates_btn') }}</a>
                <a href="{{ route('admin.announcements.show', $class) }}" class="lms-btn-primary">{{ __('lms.admin_page.announcements_btn') }}</a>
                <a href="{{ route('admin.classes.edit', $class) }}" class="lms-btn-secondary">✏️ {{ __('lms.edit') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        {{-- Class Information Card --}}
        <div class="dashboard-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span>📋</span> {{ __('lms.common.class_information') }}
            </h3>
            <div class="grid md:grid-cols-2 gap-x-5 gap-y-4 text-sm">
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.report.program') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->program->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.report.instructor') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->instructor->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.class_code') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->code }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.student_quota') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->quota }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.start_date') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->start_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.end_date') }}</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $class->end_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">{{ __('lms.common.status') }}</span>
                    <div class="mt-1">
                        @switch($class->status)
                            @case('draft')
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">{{ __('lms.common.draft') }}</span>
                                @break
                            @case('active')
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">{{ __('lms.active') }}</span>
                                @break
                            @case('completed')
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">{{ __('lms.common.completed') }}</span>
                                @break
                            @case('cancelled')
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">{{ __('lms.common.cancelled') }}</span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-slate-100">
                <span class="text-slate-400 text-xs">{{ __('lms.common.description') }}</span>
                <p class="text-sm text-slate-600 mt-1">{{ $class->description ?: __('lms.common.no_description') }}</p>
            </div>
        </div>

        {{-- Enrolled Students Card --}}
        <div class="dashboard-card bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <span>👨‍🎓</span> {{ __('lms.common.enrolled_students_count', ['current' => $class->participants->count(), 'quota' => $class->quota]) }}
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('lms.common.name') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('lms.auth.email') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.enrolled_at') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($class->participants as $participant)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $participant->participant->name }}</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">{{ $participant->participant->email }}</td>
                                <td class="px-4 py-3 text-center text-slate-600 text-xs">{{ $participant->enrolled_at?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @switch($participant->status)
                                        @case('active')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">{{ __('lms.active') }}</span>
                                            @break
                                        @case('completed')
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">{{ __('lms.common.completed') }}</span>
                                            @break
                                        @case('dropped')
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">{{ __('lms.common.dropped') }}</span>
                                            @break
                                        @default
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">{{ ucfirst($participant->status) }}</span>
                                    @endswitch
                                 </td>
                             </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400 text-sm">{{ __('lms.common.no_students') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
