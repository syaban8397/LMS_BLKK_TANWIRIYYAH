<x-app-layout>
<div class="stream-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$class->title"
            :subtitle="'Kode: ' . $class->code . ' · Instruktur: ' . $class->instructor->name"
            :back-url="route('instruktur.classes.index')"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="grid lg:grid-cols-4 gap-6">
            {{-- Sidebar Info + Quick Actions (3D card) --}}
            <div class="lg:col-span-1 space-y-5">
                {{-- Class Info Card --}}
                <div class="sidebar-card dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📋</span> Class Info
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">Program</span><span class="font-medium">{{ $class->program->name }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Capacity</span><span class="font-medium"><span class="text-emerald-600">{{ $class->participants->count() }}</span> / {{ $class->quota }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Period</span><span class="font-medium">{{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Status</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $class->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($class->status) }}</span>
                        </div>
                        <div class="pt-2 border-t"><span class="text-slate-500 text-xs">Description</span><p class="text-slate-600 mt-1 text-sm">{{ $class->description }}</p></div>
                    </div>
                </div>

                {{-- Quick Actions Card --}}
                <div class="sidebar-card dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>⚡</span> Quick Actions
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('instruktur.materials.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📖</span><span class="font-medium">All Materials</span>
                        </a>
                        <a href="{{ route('instruktur.assignments.create', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">➕</span><span class="font-medium">New Assignment</span>
                        </a>
                        <a href="{{ route('instruktur.attendances.index', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">📅</span><span class="font-medium">Manage Attendance</span>
                        </a>
                        <a href="{{ route('instruktur.classes.add-student', $class) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition text-slate-700 group">
                            <span class="text-xl group-hover:scale-110 transition">👥</span><span class="font-medium">Manage Students</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Content (Stream) --}}
            <div class="lg:col-span-3 space-y-5">
                {{-- Announcement Form --}}
                <div class="form-card dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📢</span> Post Announcement
                    </h3>
                    <form action="{{ route('instruktur.announcements.store', $class) }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="title" placeholder="Announcement title..." required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 text-sm px-3 py-2">
                        <textarea name="description" rows="2" placeholder="Write your announcement..." required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 text-sm px-3 py-2"></textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm">Post Announcement</button>
                        </div>
                    </form>
                </div>

                {{-- Quick Create Buttons (3 cards horizontal) --}}
                <div class="grid grid-cols-3 gap-4">
                    <a href="{{ route('instruktur.materials.index', $class) }}" class="quick-card bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📄</span>
                        <p class="font-bold mt-1">Add Material</p>
                        <p class="text-xs opacity-80">Upload resources</p>
                    </a>
                    <a href="{{ route('instruktur.assignments.create', $class) }}" class="quick-card bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📝</span>
                        <p class="font-bold mt-1">New Assignment</p>
                        <p class="text-xs opacity-80">Create tasks</p>
                    </a>
                    <a href="{{ route('instruktur.attendances.index', $class) }}" class="quick-card bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl p-4 shadow-md text-white text-center">
                        <span class="text-3xl block">📅</span>
                        <p class="font-bold mt-1">Take Attendance</p>
                        <p class="text-xs opacity-80">Record presence</p>
                    </a>
                </div>

                {{-- Timeline Feed (Announcements, Materials, Assignments) with 3D cards --}}
                <div class="space-y-4">
                    <!-- Announcements Section -->
                    @forelse($announcements as $announcement)
                    <div class="timeline-item dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200" id="announcement-{{ $announcement->id }}">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-400 flex items-center justify-center text-white">📢</div>
                                <div><p class="font-semibold text-slate-800">{{ $announcement->creator?->name }}</p><p class="text-xs text-slate-400">{{ $announcement->created_at->diffForHumans() }}</p></div>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="showEditForm({{ $announcement->id }}, '{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->description) }}')" class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition">Edit</button>
                                <form action="{{ route('instruktur.announcements.destroy', [$class, $announcement]) }}" method="POST" data-lms-confirm="Delete?" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="announcement-view-{{ $announcement->id }} mt-3">
                            <h4 class="font-bold text-slate-800">{{ $announcement->title }}</h4>
                            <p class="text-slate-600 text-sm mt-1 whitespace-pre-line">{{ $announcement->description }}</p>
                        </div>
                        <div class="announcement-edit-{{ $announcement->id }} mt-3" style="display:none;">
                            <form action="{{ route('instruktur.announcements.update', [$class, $announcement]) }}" method="POST" class="space-y-2">
                                @csrf @method('PUT')
                                <input type="text" name="title" value="{{ $announcement->title }}" class="input-3d w-full rounded-lg border-slate-200 text-sm px-3 py-1.5">
                                <textarea name="description" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-sm px-3 py-1.5">{{ $announcement->description }}</textarea>
                                <div class="flex gap-2"><button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs transition">Simpan</button><button type="button" onclick="cancelEdit({{ $announcement->id }})" class="px-3 py-1 bg-slate-200 rounded-md text-xs transition">Batal</button></div>
                            </form>
                        </div>
                    </div>
                    @empty <div class="timeline-item dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No announcements yet.</div> @endforelse

                    <!-- Materials -->
                    @forelse($materials as $material)
                    <div class="timeline-item dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3"><div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 flex items-center justify-center text-white">📖</div><div><p class="font-semibold text-slate-800">{{ $material->creator?->name }}</p><p class="text-xs text-slate-400">Meeting {{ $material->meeting_number }} • {{ $material->created_at->diffForHumans() }}</p></div></div>
                            <div class="flex gap-2"><a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="px-2 py-1 text-xs bg-sky-100 text-sky-700 rounded-md hover:bg-sky-200 transition">View</a><a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition">Edit</a></div>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $material->title }}</h4>
                        @if($material->description)<p class="text-slate-600 text-sm mt-1">{{ $material->description }}</p>@endif
                        <div class="flex gap-2 mt-2">@if($material->file_path)<span class="text-xs bg-slate-100 px-2 py-0.5 rounded">📎 File</span>@endif @if($material->youtube_url)<span class="text-xs bg-red-100 px-2 py-0.5 rounded">🎥 YouTube</span>@endif</div>
                    </div>
                    @empty <div class="timeline-item dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No materials yet.</div> @endforelse

                    <!-- Assignments -->
                    @forelse($assignments as $assignment)
                    @php $submittedCount = $assignment->submissions->count(); $gradedCount = $assignment->submissions->whereNotNull('score')->count(); $progress = $submittedCount > 0 ? ($gradedCount / $submittedCount) * 100 : 0; @endphp
                    <div class="timeline-item dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3"><div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white">📝</div><div><p class="font-semibold text-slate-800">{{ $assignment->creator?->name }}</p><p class="text-xs text-slate-400">Due: {{ $assignment->deadline->format('d M Y H:i') }}</p></div></div>
                            <div class="flex gap-2"><a href="{{ route('instruktur.assignments.edit', [$class, $assignment]) }}" class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition">Edit</a><a href="{{ route('instruktur.grades.index', [$class, $assignment]) }}" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition">Submissions ({{ $submittedCount }})</a><form action="{{ route('instruktur.assignments.destroy', [$class, $assignment]) }}" method="POST" data-lms-confirm="Delete?" class="inline">@csrf @method('DELETE')<button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">Delete</button></form></div>
                        </div>
                        <h4 class="font-bold text-slate-800 mt-3">{{ $assignment->title }}</h4>
                        <p class="text-slate-600 text-sm mt-1">{{ $assignment->description }}</p>
                        @if($assignment->attachment)<a href="{{ Storage::url($assignment->attachment) }}" class="text-xs text-blue-600 mt-2 inline-block hover:underline">📎 Unduh</a>@endif
                        @if($submittedCount > 0)
                        <div class="mt-3 pt-2 border-t"><div class="flex justify-between text-xs"><span>Grading Progress</span><span>{{ $gradedCount }}/{{ $submittedCount }}</span></div><div class="w-full bg-slate-200 rounded-full h-1.5 mt-1"><div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $progress }}%"></div></div></div>
                        @endif
                    </div>
                    @empty <div class="timeline-item dashboard-card bg-white rounded-xl p-6 text-center text-slate-400">No assignments yet.</div> @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEditForm(id, title, description) {
            document.querySelector('.announcement-view-' + id).style.display = 'none';
            document.querySelector('.announcement-edit-' + id).style.display = 'block';
        }
        function cancelEdit(id) {
            document.querySelector('.announcement-view-' + id).style.display = 'block';
            document.querySelector('.announcement-edit-' + id).style.display = 'none';
        }
    </script>
</x-app-layout>