<x-app-layout>
<div class="peserta-show-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.common.subtitle_code_instructor_dot', ['code' => $class->code, 'instructor' => $class->instructor->name])"
            :back-url="route('peserta.classes.index')"
            :back-label="__('lms.back')"
        >
            <x-slot:actions>
                <a href="{{ route('peserta.classes.stream', $class) }}" class="lms-btn-primary btn-3d">📢 {{ __('lms.common.class_stream') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="info-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('lms.common.class_information') }}
                </h3>
            </div>
            <div class="p-5">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.report.program') }}</p><p class="text-slate-800 font-semibold">{{ $class->program->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.report.instructor') }}</p><p class="text-slate-800 font-semibold">{{ $class->instructor->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.enrollment_status') }}</p>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                @switch($participation->status)
                                    @case('active') bg-green-100 text-green-700 @break
                                    @case('completed') bg-blue-100 text-blue-700 @break
                                    @case('dropped') bg-red-100 text-red-700 @break
                                    @default bg-slate-100 text-slate-700
                                @endswitch">
                                @switch($participation->status)
                                    @case('active') {{ __('lms.active') }} @break
                                    @case('completed') {{ __('lms.common.completed') }} @break
                                    @case('dropped') {{ __('lms.common.dropped') }} @break
                                    @default {{ $participation->status }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.start_date') }}</p><p class="text-slate-800 font-semibold">{{ $class->start_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.end_date') }}</p><p class="text-slate-800 font-semibold">{{ $class->end_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">{{ __('lms.common.enrolled_at') }}</p><p class="text-slate-800 font-semibold">{{ $participation->enrolled_at?->format('d F Y') ?? '-' }}</p></div>
                    </div>
                </div>
                @if($class->description)
                <div class="mt-5 pt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold uppercase mb-2">{{ __('lms.common.description') }}</p>
                    <p class="text-slate-700 text-sm">{{ $class->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('peserta.materials.index', $class) }}" class="quick-card bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📖</div>
                <h4 class="font-bold text-base">{{ __('lms.dashboard.materials') }}</h4>
                <p class="text-xs text-blue-100 mt-1">{{ __('lms.common.view_resources') }}</p>
            </a>
            <a href="{{ route('peserta.assignments.index', $class) }}" class="quick-card bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📝</div>
                <h4 class="font-bold text-base">{{ __('lms.dashboard.assignments') }}</h4>
                <p class="text-xs text-purple-100 mt-1">{{ __('lms.common.submit_tasks') }}</p>
            </a>
            <a href="{{ route('peserta.attendances.index', $class) }}" class="quick-card bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📅</div>
                <h4 class="font-bold text-base">{{ __('lms.common.attendance') }}</h4>
                <p class="text-xs text-amber-100 mt-1">{{ __('lms.common.record_presence') }}</p>
            </a>
            <a href="{{ route('peserta.assignments.index', $class) }}" class="quick-card bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">🎯</div>
                <h4 class="font-bold text-base">{{ __('lms.common.my_grades') }}</h4>
                <p class="text-xs text-green-100 mt-1">{{ __('lms.common.check_progress') }}</p>
                <span class="inline-block mt-2 text-xs bg-white/20 rounded-lg px-2 py-0.5">{{ __('lms.dashboard.view_class') }}</span>
            </a>
        </div>

        <div class="announcement-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    {{ __('lms.common.latest_from_instructor') }}
                </h3>
                <span class="text-xs text-slate-400">{{ __('lms.common.instructor_updates') }}</span>
            </div>
            <div class="p-5">
                @if(isset($announcements) && $announcements->count() > 0)
                    <div class="space-y-4">
                        @foreach($announcements->take(3) as $announcement)
                        <div class="pb-3 border-b border-slate-100 last:border-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-slate-800">{{ $announcement->title }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mt-2">{{ Str::limit($announcement->description, 120) }}</p>
                        </div>
                        @endforeach
                    </div>
                    @if($announcements->count() > 3)
                    <div class="mt-4 text-right">
                        <a href="{{ route('peserta.classes.stream', $class) }}" class="text-xs text-blue-600 hover:underline">{{ __('lms.common.view_all_announcements') }}</a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-6 text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        <p class="text-sm">{{ __('lms.common.no_announcements_yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
