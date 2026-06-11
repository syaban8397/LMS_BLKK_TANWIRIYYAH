<x-app-layout>
    <div class="space-y-6">
        {{-- Header (sama persis gaya instruktur) --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $class->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Class Code: <span class="font-mono bg-slate-100 px-2 py-0.5 rounded-md">{{ $class->code }}</span> 
                    • Instructor: {{ $class->instructor->name }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.classes.index') }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Classes
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid lg:grid-cols-4 gap-6">
            {{-- Sidebar Info + Quick Links (sama gaya instruktur) --}}
            <div class="lg:col-span-1 space-y-5">
                {{-- Class Info Card (3D) --}}
                <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📋</span> Class Info
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">Program</span><span class="font-medium">{{ $class->program->name }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Status</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                        </div>
                        <div class="flex justify-between"><span class="text-slate-500">Period</span><span class="font-medium">{{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}</span></div>
                        <div class="pt-2 border-t"><span class="text-slate-500 text-xs">Description</span><p class="text-slate-600 mt-1 text-sm">{{ $class->description }}</p></div>
                    </div>
                </div>

                {{-- Quick Links Card (mirip quick actions instruktur) --}}
                <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>🔗</span> Quick Links
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('peserta.materials.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📖</span><span class="font-medium">All Materials</span>
                        </a>
                        <a href="{{ route('peserta.assignments.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📝</span><span class="font-medium">All Assignments</span>
                        </a>
                        <a href="{{ route('peserta.attendances.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📅</span><span class="font-medium">My Attendance</span>
                        </a>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📊</span> Statistics
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-600">Announcements</span><span class="font-bold text-slate-800">{{ $announcements->count() }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">Materials</span><span class="font-bold text-slate-800">{{ $materials->count() }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">Assignments</span><span class="font-bold text-slate-800">{{ $assignments->count() }}</span></div>
                        @if(isset($attendances))<div class="flex justify-between"><span class="text-slate-600">Attendance Sessions</span><span class="font-bold text-slate-800">{{ $attendances->count() }}</span></div>@endif
                    </div>
                </div>
            </div>

            {{-- Main Content (Stream) --}}
            <div class="lg:col-span-3 space-y-5">
                {{-- Action Buttons (3D gradien cards seperti quick-card instruktur) --}}
                <div class="grid grid-cols-3 gap-4">
                    <a href="{{ route('peserta.materials.index', $class) }}" class="quick-card bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-4 shadow-md text-white text-center hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="text-3xl block">📖</span>
                        <p class="font-bold mt-1">Materials</p>
                        <p class="text-xs opacity-80">Browse resources</p>
                    </a>
                    <a href="{{ route('peserta.assignments.index', $class) }}" class="quick-card bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-4 shadow-md text-white text-center hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="text-3xl block">📝</span>
                        <p class="font-bold mt-1">Assignments</p>
                        <p class="text-xs opacity-80">Submit tasks</p>
                    </a>
                    <a href="{{ route('peserta.attendances.index', $class) }}" class="quick-card bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl p-4 shadow-md text-white text-center hover:shadow-lg hover:-translate-y-1 transition">
                        <span class="text-3xl block">📅</span>
                        <p class="font-bold mt-1">Attendance</p>
                        <p class="text-xs opacity-80">Record presence</p>
                    </a>
                </div>

                {{-- Timeline Feed (semua card 3D) --}}
                <div class="space-y-4">
                    {{-- Announcements --}}
                    @forelse($announcements as $announcement)
                    <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-400 flex items-center justify-center text-white text-lg">📢</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $announcement->creator?->name ?? 'System' }}</p>
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
                    <div class="dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No announcements yet.</div>
                    @endforelse

                    {{-- Materials --}}
                    @forelse($materials as $material)
                    <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 flex items-center justify-center text-white text-lg">📖</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $material->creator?->name ?? 'Instructor' }}</p>
                                    <p class="text-xs text-slate-400">Meeting {{ $material->meeting_number }} • {{ $material->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('peserta.materials.show', [$class, $material]) }}" class="btn-3d px-3 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">View</a>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $material->title }}</h4>
                        @if($material->description)<p class="text-slate-600 text-sm mt-1">{{ $material->description }}</p>@endif
                        <div class="flex gap-2 mt-2">
                            @if($material->file_path)<span class="text-xs bg-slate-100 px-2 py-0.5 rounded">📎 File</span>@endif
                            @if($material->youtube_url)<span class="text-xs bg-red-100 px-2 py-0.5 rounded">🎥 YouTube</span>@endif
                        </div>
                    </div>
                    @empty
                    <div class="dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No materials yet.</div>
                    @endforelse

                    {{-- Assignments dengan status submission --}}
                    @forelse($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->where('participant_id', auth()->id())->first();
                        $statusBadge = '';
                        $statusColor = '';
                        if($submission && $submission->isGraded()) {
                            $statusBadge = 'Graded • Score: '.$submission->score;
                            $statusColor = 'bg-green-100 text-green-700';
                        } elseif($submission) {
                            $statusBadge = 'Submitted';
                            $statusColor = 'bg-yellow-100 text-yellow-700';
                        } else {
                            $statusBadge = 'Not submitted';
                            $statusColor = 'bg-red-100 text-red-700';
                        }
                    @endphp
                    <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200 border-l-4 border-l-purple-500">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white text-lg">📝</div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $assignment->creator?->name ?? 'Instructor' }}</p>
                                    <p class="text-xs text-slate-400">
                                        @if($assignment->deadline->isFuture())
                                            Due: {{ $assignment->deadline->format('d M Y H:i') }}
                                        @else
                                            <span class="text-red-600 font-medium">Ended: {{ $assignment->deadline->format('d M Y H:i') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">{{ $statusBadge }}</span>
                                <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="btn-3d px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs transition shadow-sm">View</a>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $assignment->title }}</h4>
                        <p class="text-slate-600 text-sm mt-1">{{ $assignment->description }}</p>
                        @if($assignment->attachment)
                            <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-xs text-blue-600 mt-2 inline-block hover:underline">📎 Download attachment</a>
                        @endif
                    </div>
                    @empty
                    <div class="dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No assignments yet.</div>
                    @endforelse

                    {{-- Attendance Summary Card (jika ada) --}}
                    @if(isset($attendances) && $attendances->count() > 0)
                    <div class="dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200 border-l-4 border-l-green-500">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-teal-400 flex items-center justify-center text-white text-lg">📅</div>
                                <div>
                                    <p class="font-semibold text-slate-800">Attendance Summary</p>
                                    <p class="text-xs text-slate-400">Your attendance records</p>
                                </div>
                            </div>
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="btn-3d px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition shadow-sm">View All</a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                            <div class="text-center p-2 bg-green-50 rounded-lg border border-green-200 hover:-translate-y-1 transition">
                                <p class="text-2xl font-bold text-green-700">{{ $attendances->where('status', 'present')->count() }}</p>
                                <p class="text-xs text-green-600">Present</p>
                            </div>
                            <div class="text-center p-2 bg-yellow-50 rounded-lg border border-yellow-200 hover:-translate-y-1 transition">
                                <p class="text-2xl font-bold text-yellow-700">{{ $attendances->where('status', 'permission')->count() }}</p>
                                <p class="text-xs text-yellow-600">Permission</p>
                            </div>
                            <div class="text-center p-2 bg-orange-50 rounded-lg border border-orange-200 hover:-translate-y-1 transition">
                                <p class="text-2xl font-bold text-orange-700">{{ $attendances->where('status', 'sick')->count() }}</p>
                                <p class="text-xs text-orange-600">Sick</p>
                            </div>
                            <div class="text-center p-2 bg-red-50 rounded-lg border border-red-200 hover:-translate-y-1 transition">
                                <p class="text-2xl font-bold text-red-700">{{ $attendances->where('status', 'absent')->count() }}</p>
                                <p class="text-xs text-red-600">Absent</p>
                            </div>
                        </div>
                        @php
                            $totalMeetings = $attendances->count();
                            $presentCount = $attendances->where('status', 'present')->count();
                            $attRate = $totalMeetings > 0 ? round(($presentCount / $totalMeetings) * 100) : 0;
                        @endphp
                        <div class="mt-4 pt-3 border-t border-slate-200">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-600">Attendance Rate</span>
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

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
        .quick-card {
            transition: all 0.2s ease;
        }
        .quick-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.25);
        }
        .quick-card:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>