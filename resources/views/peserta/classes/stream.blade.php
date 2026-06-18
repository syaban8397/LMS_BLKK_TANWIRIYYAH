<x-app-layout>
<div class="peserta-stream-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$class->title"
            :subtitle="__('lms.common.subtitle_code_instructor', ['code' => $class->code, 'instructor' => $class->instructor->name])"
            :back-url="route('peserta.classes.show', $class)"
            :back-label="__('lms.common.class_detail')"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="grid lg:grid-cols-4 gap-6">
            <div class="lg:col-span-1 space-y-5">
                <div class="sidebar-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📋</span> {{ __('lms.common.class_info') }}
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.report.program') }}</span><span class="font-medium">{{ $class->program->name }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.common.status') }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ __('lms.active') }}</span>
                        </div>
                        <div class="flex justify-between"><span class="text-slate-500">{{ __('lms.common.period') }}</span><span class="font-medium">{{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}</span></div>
                        <div class="pt-2 border-t"><span class="text-slate-500 text-xs">{{ __('lms.common.description') }}</span><p class="text-slate-600 mt-1 text-sm">{{ $class->description ?: __('lms.common.no_description') }}</p></div>
                    </div>
                </div>

                <div class="sidebar-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>🔗</span> {{ __('lms.common.quick_links') }}
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('peserta.materials.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📖</span><span class="font-medium">{{ __('lms.common.all_materials') }}</span>
                        </a>
                        <a href="{{ route('peserta.assignments.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📝</span><span class="font-medium">{{ __('lms.common.all_assignments') }}</span>
                        </a>
                        <a href="{{ route('peserta.attendances.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📅</span><span class="font-medium">{{ __('lms.common.my_attendance') }}</span>
                        </a>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📊</span> {{ __('lms.common.statistics') }}
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-600">{{ __('lms.common.announcements_label') }}</span><span class="font-bold text-slate-800">{{ $announcements->count() }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">{{ __('lms.dashboard.materials') }}</span><span class="font-bold text-slate-800">{{ $materials->count() }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">{{ __('lms.dashboard.assignments') }}</span><span class="font-bold text-slate-800">{{ $assignments->count() }}</span></div>
                        @if(isset($attendances))<div class="flex justify-between"><span class="text-slate-600">{{ __('lms.dashboard.attendance_sessions') }}</span><span class="font-bold text-slate-800">{{ $attendances->count() }}</span></div>@endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-5">
                <div class="grid grid-cols-3 gap-4">
                    <a href="{{ route('peserta.materials.index', $class) }}" class="quick-card bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📖</span>
                        <p class="font-bold mt-1">{{ __('lms.dashboard.materials') }}</p>
                        <p class="text-xs opacity-80">{{ __('lms.common.browse_resources') }}</p>
                    </a>
                    <a href="{{ route('peserta.assignments.index', $class) }}" class="quick-card bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📝</span>
                        <p class="font-bold mt-1">{{ __('lms.dashboard.assignments') }}</p>
                        <p class="text-xs opacity-80">{{ __('lms.common.submit_tasks') }}</p>
                    </a>
                    <a href="{{ route('peserta.attendances.index', $class) }}" class="quick-card bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📅</span>
                        <p class="font-bold mt-1">{{ __('lms.common.attendance') }}</p>
                        <p class="text-xs opacity-80">{{ __('lms.common.record_presence') }}</p>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($announcements as $announcement)
                    <div class="timeline-item bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-400 flex items-center justify-center text-white text-lg">📢</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $announcement->creator?->name ?? __('lms.common.system') }}</p>
                                    <p class="text-xs text-slate-400">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h4 class="font-bold text-slate-800">{{ $announcement->title }}</h4>
                            <p class="text-slate-600 text-sm mt-1 whitespace-pre-line">{{ $announcement->description }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="timeline-item bg-white rounded-xl p-6 text-center text-slate-400">{{ __('lms.common.no_announcements') }}</div>
                    @endforelse

                    @forelse($materials as $material)
                    <div class="timeline-item bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 flex items-center justify-center text-white text-lg">📖</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $material->creator?->name ?? __('lms.common.instructor_fallback') }}</p>
                                    <p class="text-xs text-slate-400">{{ __('lms.common.meeting') }} {{ $material->meeting_number }} • {{ $material->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="btn-3d px-3 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.view') }}</a>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $material->title }}</h4>
                        @if($material->description)<p class="text-slate-600 text-sm mt-1">{{ $material->description }}</p>@endif
                    </div>
                    @empty
                    <div class="timeline-item bg-white rounded-xl p-6 text-center text-slate-400">{{ __('lms.common.no_materials') }}</div>
                    @endforelse

                    @forelse($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                        if($submission && $submission->isGraded()) {
                            $statusBadge = __('lms.common.graded');
                            $statusColor = 'bg-green-100 text-green-700';
                        } elseif($submission) {
                            $statusBadge = __('lms.common.submitted');
                            $statusColor = 'bg-yellow-100 text-yellow-700';
                        } else {
                            $statusBadge = __('lms.common.not_submitted');
                            $statusColor = 'bg-red-100 text-red-700';
                        }
                    @endphp
                    <div class="timeline-item bg-white rounded-xl p-5 shadow-md border border-slate-200 border-l-4 border-l-purple-500">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white text-lg">📝</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $assignment->creator?->name ?? __('lms.common.instructor_fallback') }}</p>
                                    <p class="text-xs text-slate-400">
                                        @if($assignment->deadline->isFuture())
                                            {{ __('lms.common.due_label') }} {{ $assignment->deadline->format('d M Y H:i') }}
                                        @else
                                            <span class="text-red-600 font-medium">{{ __('lms.common.ended_label') }} {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">{{ $statusBadge }}</span>
                                <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="btn-3d px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.view') }}</a>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $assignment->title }}</h4>
                        <p class="text-slate-600 text-sm mt-1">{{ $assignment->description }}</p>
                        @if($assignment->attachment)
                            <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-xs text-blue-600 mt-2 inline-block hover:underline">📎 {{ __('lms.common.download') }} {{ __('lms.common.attachment') }}</a>
                        @endif
                    </div>
                    @empty
                    <div class="timeline-item bg-white rounded-xl p-6 text-center text-slate-400">{{ __('lms.common.no_assignments') }}</div>
                    @endforelse

                    @if(isset($attendances) && $attendances->count() > 0)
                    <div class="timeline-item bg-white rounded-xl p-5 shadow-md border border-slate-200 border-l-4 border-l-green-500">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-teal-400 flex items-center justify-center text-white text-lg">📅</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ __('lms.common.attendance_summary') }}</p>
                                    <p class="text-xs text-slate-400">{{ __('lms.common.attendance_records') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="btn-3d px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.common.view_all_btn') }}</a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                            <div class="text-center p-2 bg-green-50 rounded-lg border border-green-200 hover:-translate-y-1 transition"><p class="text-2xl font-bold text-green-700">{{ $attendances->where('status', 'present')->count() }}</p><p class="text-xs text-green-600">{{ __('lms.report.present') }}</p></div>
                            <div class="text-center p-2 bg-yellow-50 rounded-lg border border-yellow-200 hover:-translate-y-1 transition"><p class="text-2xl font-bold text-yellow-700">{{ $attendances->where('status', 'permission')->count() }}</p><p class="text-xs text-yellow-600">{{ __('lms.report.permission') }}</p></div>
                            <div class="text-center p-2 bg-orange-50 rounded-lg border border-orange-200 hover:-translate-y-1 transition"><p class="text-2xl font-bold text-orange-700">{{ $attendances->where('status', 'sick')->count() }}</p><p class="text-xs text-orange-600">{{ __('lms.report.sick') }}</p></div>
                            <div class="text-center p-2 bg-red-50 rounded-lg border border-red-200 hover:-translate-y-1 transition"><p class="text-2xl font-bold text-red-700">{{ $attendances->where('status', 'absent')->count() }}</p><p class="text-xs text-red-600">{{ __('lms.report.absent') }}</p></div>
                        </div>
                        @php
                            $totalMeetings = $attendances->count();
                            $presentCount = $attendances->where('status', 'present')->count();
                            $attRate = $totalMeetings > 0 ? round(($presentCount / $totalMeetings) * 100) : 0;
                        @endphp
                        <div class="mt-4 pt-3 border-t border-slate-200">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-600">{{ __('lms.dashboard.attendance_rate') }}</span>
                                <span class="font-bold text-green-700">{{ $attRate }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-green-600 h-full rounded-full" style="width: {{ $attRate }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
