<x-app-layout>
<div class="peserta-show-wrapper space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $class->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Class code: <span class="font-mono bg-slate-100 px-2 py-0.5 rounded-md">{{ $class->code }}</span> • Instructor: {{ $class->instructor->name }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.classes.index') }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Classes
                </a>
            </div>
        </div>

        @if(session('success')) <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm animate-pulse">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm animate-pulse">{{ session('error') }}</div> @endif

        <!-- Class Info Card -->
        <div class="info-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Class Information
                </h3>
            </div>
            <div class="p-5">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">Program</p><p class="text-slate-800 font-semibold">{{ $class->program->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">Instructor</p><p class="text-slate-800 font-semibold">{{ $class->instructor->name }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">Enrollment Status</p>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                @switch($participation->status)
                                    @case('active') bg-green-100 text-green-700 @break
                                    @case('completed') bg-blue-100 text-blue-700 @break
                                    @case('dropped') bg-red-100 text-red-700 @break
                                    @default bg-slate-100 text-slate-700
                                @endswitch">
                                {{ ucfirst($participation->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">Start Date</p><p class="text-slate-800 font-semibold">{{ $class->start_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">End Date</p><p class="text-slate-800 font-semibold">{{ $class->end_date->format('d F Y') }}</p></div>
                        <div><p class="text-xs text-slate-500 font-semibold uppercase">Enrolled At</p><p class="text-slate-800 font-semibold">{{ $participation->enrolled_at?->format('d F Y') ?? '-' }}</p></div>
                    </div>
                </div>
                @if($class->description)
                <div class="mt-5 pt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold uppercase mb-2">Description</p>
                    <p class="text-slate-700 text-sm">{{ $class->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Access Cards (4 kartu gradien) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('peserta.materials.index', $class) }}" class="quick-card bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📖</div>
                <h4 class="font-bold text-base">Materials</h4>
                <p class="text-xs text-blue-100 mt-1">View resources</p>
            </a>
            <a href="{{ route('peserta.assignments.index', $class) }}" class="quick-card bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📝</div>
                <h4 class="font-bold text-base">Assignments</h4>
                <p class="text-xs text-purple-100 mt-1">Submit tasks</p>
            </a>
            <a href="{{ route('peserta.attendances.index', $class) }}" class="quick-card bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">📅</div>
                <h4 class="font-bold text-base">Attendance</h4>
                <p class="text-xs text-amber-100 mt-1">Record presence</p>
            </a>
            <a href="#" class="quick-card bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-5 shadow-md text-white text-center">
                <div class="text-4xl mb-2">🎯</div>
                <h4 class="font-bold text-base">My Grades</h4>
                <p class="text-xs text-green-100 mt-1">Check progress</p>
                <span class="inline-block mt-2 text-xs bg-white/20 rounded-lg px-2 py-0.5">View →</span>
            </a>
        </div>

        <!-- Latest Announcements Card -->
        <div class="announcement-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Latest Announcements
                </h3>
                <span class="text-xs text-slate-400">Latest updates from instructor</span>
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
                        <a href="{{ route('peserta.classes.stream', $class) }}" class="text-xs text-blue-600 hover:underline">View all announcements →</a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-6 text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        <p class="text-sm">No announcements yet. Check back soon!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>