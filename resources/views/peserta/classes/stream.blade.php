<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $class->title }}</h2>
                <p class="text-sm text-slate-500 mt-1">Instructor: <span class="font-semibold">{{ $class->instructor->name }}</span></p>
            </div>
            <a href="{{ route('peserta.classes.index') }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">Back</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">{{ session('error') }}</div>
        @endif

        <div class="flex flex-wrap -mx-3">
            {{-- STREAM CONTENT (col-8) --}}
            <div class="w-full lg:w-2/3 px-3">
                <div class="space-y-4">
                    {{-- ACTION BUTTONS --}}
                    <div class="grid grid-cols-3 gap-4">
                        <a href="{{ route('peserta.materials.index', $class) }}" class="px-4 py-3 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">📖 Materials</a>
                        {{-- <a href="{{ route('peserta.assignments.index', $class) }}" class="px-4 py-3 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">📝 Assignments</a> --}}
                        <a href="{{ route('peserta.attendances.index', $class) }}" class="px-4 py-3 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">📅 Attendance</a>
                    </div>

                    {{-- STREAM POSTS --}}
                    <div class="space-y-4">
                        {{-- ANNOUNCEMENTS --}}
                        @forelse($announcements as $announcement)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-lg flex-shrink-0">📢</div>
                                <div class="flex-1"><p class="font-bold text-slate-800">{{ $announcement->creator?->name }}</p><p class="text-xs text-slate-500">{{ $announcement->created_at->format('d M Y H:i') }}</p></div>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">{{ $announcement->title }}</h4>
                            <p class="text-slate-700 whitespace-pre-line">{{ $announcement->description }}</p>
                        </div>
                        @empty @endforelse

                        {{-- MATERIALS --}}
                        @forelse($materials as $material)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-start gap-4"><div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-lg flex-shrink-0">📖</div><div><p class="font-bold text-slate-800">{{ $material->creator?->name }}</p><p class="text-xs text-slate-500">Meeting {{ $material->meeting_number }} • {{ $material->created_at->format('d M Y H:i') }}</p></div></div>
                                <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="px-3 py-1 text-sm bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition flex-shrink-0">View</a>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">{{ $material->title }}</h4>
                            @if($material->description)<p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $material->description }}</p>@endif
                            <div class="flex flex-wrap gap-2 text-xs">@if($material->file_path)<span class="px-2 py-1 bg-green-100 text-green-700 rounded">📎 {{ strtoupper($material->file_type) }}</span>@endif @if($material->youtube_url)<span class="px-2 py-1 bg-red-100 text-red-700 rounded">🎥 YouTube</span>@endif</div>
                        </div>
                        @empty @endforelse

                        {{-- ASSIGNMENTS --}}
                        @forelse($assignments as $assignment)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 border-l-4 border-l-purple-500">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-start gap-4"><div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-lg flex-shrink-0">📝</div><div><p class="font-bold text-slate-800">{{ $assignment->creator?->name }}</p><p class="text-xs text-slate-500">@if($assignment->deadline->isFuture())Due: {{ $assignment->deadline->format('d M Y H:i') }}@else<span class="text-red-600 font-medium">Ended: {{ $assignment->deadline->format('d M Y H:i') }}</span>@endif</p></div></div>
                                <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex-shrink-0">View</a>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">{{ $assignment->title }}</h4>
                            <p class="text-slate-700 line-clamp-3">{{ $assignment->description }}</p>
                        </div>
                        @empty @endforelse

                        {{-- ATTENDANCES (Added for peserta to see their attendance status) --}}
                        @if(isset($attendances) && $attendances->count() > 0)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 border-l-4 border-l-green-500">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-lg flex-shrink-0">📅</div>
                                <div class="flex-1"><p class="font-bold text-slate-800">Attendance Summary</p><p class="text-xs text-slate-500">Your attendance records for this class</p></div>
                                <a href="{{ route('peserta.attendances.index', $class) }}" class="px-3 py-1 text-sm bg-green-500 hover:bg-green-600 text-white rounded-lg transition flex-shrink-0">View All</a>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                <div class="text-center p-3 bg-green-50 rounded-2xl"><p class="text-2xl font-bold text-green-700">{{ $attendances->where('status', 'present')->count() }}</p><p class="text-xs text-green-600">Present</p></div>
                                <div class="text-center p-3 bg-yellow-50 rounded-2xl"><p class="text-2xl font-bold text-yellow-700">{{ $attendances->where('status', 'permission')->count() }}</p><p class="text-xs text-yellow-600">Permission</p></div>
                                <div class="text-center p-3 bg-orange-50 rounded-2xl"><p class="text-2xl font-bold text-orange-700">{{ $attendances->where('status', 'sick')->count() }}</p><p class="text-xs text-orange-600">Sick</p></div>
                                <div class="text-center p-3 bg-red-50 rounded-2xl"><p class="text-2xl font-bold text-red-700">{{ $attendances->where('status', 'absent')->count() }}</p><p class="text-xs text-red-600">Absent</p></div>
                            </div>
                            @php
                                $totalMeetings = $attendances->count();
                                $presentCount = $attendances->where('status', 'present')->count();
                                $attendanceRate = $totalMeetings > 0 ? round(($presentCount / $totalMeetings) * 100) : 0;
                            @endphp
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <div class="flex justify-between text-sm mb-2"><span class="text-slate-600">Attendance Rate</span><span class="font-bold text-green-700">{{ $attendanceRate }}%</span></div>
                                <div class="w-full bg-slate-200 rounded-full h-2"><div class="bg-green-600 h-2 rounded-full" style="width: {{ $attendanceRate }}%"></div></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- SIDEBAR (col-4) --}}
            <div class="w-full lg:w-1/3 px-3">
                <div class="space-y-4">
                    {{-- QUICK LINKS --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h4 class="font-bold text-slate-800 mb-4">Quick Links</h4>
                        <div class="space-y-2">
                            <a href="{{ route('peserta.materials.index', $class) }}" class="block px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📖 All Materials</a>
                            {{-- <a href="{{ route('peserta.assignments.index', $class) }}" class="block px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📝 All Assignments</a> --}}
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="block px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📅 My Attendance</a>
                        </div>
                    </div>

                    {{-- CLASS INFO --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h4 class="font-bold text-slate-800 mb-4">Class Info</h4>
                        <div class="space-y-3 text-sm">
                            <div><p class="text-slate-500">Program</p><p class="font-semibold text-slate-800">{{ $class->program->name }}</p></div>
                            <div><p class="text-slate-500">Instructor</p><p class="font-semibold text-slate-800">{{ $class->instructor->name }}</p></div>
                            <div><p class="text-slate-500">Period</p><p class="font-semibold text-slate-800">{{ $class->start_date->format('d M') }} - {{ $class->end_date->format('d M Y') }}</p></div>
                            <div><p class="text-slate-500">Class Code</p><p class="font-semibold text-slate-800">{{ $class->code }}</p></div>
                        </div>
                    </div>

                    {{-- QUICK STATS --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h4 class="font-bold text-slate-800 mb-4">Stats</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-slate-600">Announcements</span><span class="font-bold text-slate-800">{{ $announcements->count() }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-600">Materials</span><span class="font-bold text-slate-800">{{ $materials->count() }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-600">Assignments</span><span class="font-bold text-slate-800">{{ $assignments->count() }}</span></div>
                            @if(isset($attendances))
                            <div class="flex justify-between"><span class="text-slate-600">Attendance Sessions</span><span class="font-bold text-slate-800">{{ $attendances->count() }}</span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>