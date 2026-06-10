<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $class->title }}</h2>
                <p class="text-sm text-slate-500 mt-1">Class code: <span class="font-semibold">{{ $class->code }}</span></p>
            </div>
            <a href="{{ route('instruktur.classes.index') }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">Back</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">{{ session('success') }}</div>
        @endif

        <div class="flex flex-wrap -mx-3">
            {{-- CLASS INFORMATION (col-3) --}}
            <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 mb-4">Class Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div><p class="text-xs text-slate-500 font-medium">Program</p><p class="text-slate-800 font-semibold text-sm">{{ $class->program->name }}</p></div>
                            <div><p class="text-xs text-slate-500 font-medium">Class Code</p><p class="text-slate-800 font-semibold text-sm">{{ $class->code }}</p></div>
                            <div><p class="text-xs text-slate-500 font-medium">Student Quota</p><p class="text-slate-800 font-semibold text-sm"><span class="text-green-600">{{ $class->participants->count() }}</span> / <span class="text-slate-600">{{ $class->quota }}</span></p></div>
                        </div>
                        <div class="space-y-3">
                            <div><p class="text-xs text-slate-500 font-medium">Start Date</p><p class="text-slate-800 font-semibold text-sm">{{ $class->start_date->format('d F Y') }}</p></div>
                            <div><p class="text-xs text-slate-500 font-medium">End Date</p><p class="text-slate-800 font-semibold text-sm">{{ $class->end_date->format('d F Y') }}</p></div>
                            <div><p class="text-xs text-slate-500 font-medium">Status</p>
                                <p class="text-slate-800 font-semibold">
                                    @php
                                        $statusBadge = ['draft' => 'bg-slate-100 text-slate-600', 'active' => 'bg-green-100 text-green-700', 'completed' => 'bg-blue-100 text-blue-700', 'cancelled' => 'bg-red-100 text-red-700'];
                                        $statusText = ['draft' => 'Draft', 'active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs {{ $statusBadge[$class->status] ?? 'bg-slate-100 text-slate-600' }}">{{ $statusText[$class->status] ?? ucfirst($class->status) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <p class="text-xs text-slate-500 font-medium mb-1">Description</p>
                        <p class="text-slate-700 text-sm">{{ $class->description }}</p>
                    </div>
                </div>

                {{-- QUICK LINKS --}}
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mt-6">
                    <h4 class="font-bold text-slate-800 mb-4">Quick Links</h4>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('instruktur.materials.index', $class) }}" class="px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📖 All Materials</a>
                        <a href="{{ route('instruktur.assignments.create', $class) }}" class="px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📝 All Assignments</a>
                        <a href="{{ route('instruktur.attendances.index', $class) }}" class="px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">📅 All Attendance</a>
                        <a href="{{ route('instruktur.classes.add-student', $class) }}" class="px-4 py-2 hover:bg-slate-50 rounded-lg text-sm text-blue-600 transition">👥 Add Students</a>
                    </div>
                </div>
            </div>

            {{-- STREAM CONTENT (col-9) --}}
            <div class="w-full md:w-3/4 px-3">
                <div class="space-y-4">
                    {{-- POST ANNOUNCEMENT --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-bold text-slate-800 mb-4 text-base">📢 Share Announcement</h3>
                        <form action="{{ route('instruktur.announcements.store', $class) }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="title" placeholder="Announcement title..." required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700 text-sm">
                            <textarea name="description" rows="3" placeholder="Write your announcement..." required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700 text-sm"></textarea>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-sm transition">Post Announcement</button>
                        </form>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="grid grid-cols-3 gap-4">
                        <a href="{{ route('instruktur.materials.create', $class) }}" class="px-4 py-3 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">+ Add Material</a>
                        <a href="{{ route('instruktur.assignments.create', $class) }}" class="px-4 py-3 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">+ New Assignment</a>
                        <a href="{{ route('instruktur.attendances.create', $class) }}" class="px-4 py-3 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl shadow-sm transition text-center font-medium text-sm">📅 Take Attendance</a>
                    </div>

                    {{-- STREAM POSTS --}}
                    <div class="space-y-4">
                        {{-- ANNOUNCEMENTS --}}
                        @forelse($announcements as $announcement)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6" id="announcement-{{ $announcement->id }}">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-lg">📢</div><div><p class="font-bold text-slate-800">{{ $announcement->creator?->name }}</p><p class="text-xs text-slate-500">{{ $announcement->created_at->format('d M Y H:i') }}</p></div></div>
                                <div class="flex gap-2">
                                    <button onclick="showEditForm({{ $announcement->id }}, '{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->description) }}')" class="px-3 py-1 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition">Edit</button>
                                    <form action="{{ route('instruktur.announcements.destroy', [$class, $announcement]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this announcement?');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition">Delete</button></form>
                                </div>
                            </div>
                            <div class="announcement-view-{{ $announcement->id }}">
                                <h4 class="font-bold text-slate-800 mb-2">{{ $announcement->title }}</h4>
                                <p class="text-slate-700 whitespace-pre-line">{{ $announcement->description }}</p>
                            </div>
                            <div class="announcement-edit-{{ $announcement->id }}" style="display: none;">
                                <form action="{{ route('instruktur.announcements.update', [$class, $announcement]) }}" method="POST" class="space-y-3">
                                    @csrf @method('PUT')
                                    <input type="text" name="title" value="{{ $announcement->title }}" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-3 py-2 text-slate-700 text-sm">
                                    <textarea name="description" rows="3" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-3 py-2 text-slate-700 text-sm">{{ $announcement->description }}</textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Update</button>
                                        <button type="button" onclick="cancelEdit({{ $announcement->id }})" class="px-3 py-1.5 text-sm bg-slate-300 hover:bg-slate-400 text-slate-700 rounded-lg transition">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty @endforelse

                        {{-- MATERIALS --}}
                        @forelse($materials as $material)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-lg">📖</div><div><p class="font-bold text-slate-800">{{ $material->creator?->name }}</p><p class="text-xs text-slate-500">Meeting {{ $material->meeting_number }} • {{ $material->created_at->format('d M Y H:i') }}</p></div></div>
                                <div class="flex gap-2"><a href="{{ route('instruktur.materials.show', [$class, $material]) }}" class="px-3 py-1 text-sm bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition">View</a><a href="{{ route('instruktur.materials.edit', [$class, $material]) }}" class="px-3 py-1 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition">Edit</a></div>
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
                                <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-lg">📝</div><div><p class="font-bold text-slate-800">{{ $assignment->creator?->name }}</p><p class="text-xs text-slate-500">@if($assignment->deadline->isFuture())Due: {{ $assignment->deadline->format('d M Y H:i') }}@else Ended: {{ $assignment->deadline->format('d M Y H:i') }}@endif</p></div></div>
                                <div class="flex gap-2">
                                    <a href="{{ route('instruktur.assignments.edit', [$class, $assignment]) }}" class="px-3 py-1 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition">Edit</a>
                                    <form action="{{ route('instruktur.assignments.destroy', [$class, $assignment]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this assignment?');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition">Delete</button></form>
                                </div>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">{{ $assignment->title }}</h4>
                            <p class="text-slate-700 whitespace-pre-line mb-3">{{ $assignment->description }}</p>
                            @if($assignment->attachment)<a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-sm text-blue-600 hover:underline">📎 Download Attachment</a>@endif
                        </div>
                        @empty @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function showEditForm(id, title, description) {
    document.querySelector('.announcement-view-' + id).style.display = 'none';
    document.querySelector('.announcement-edit-' + id).style.display = 'block';
}

function cancelEdit(id) {
    document.querySelector('.announcement-view-' + id).style.display = 'block';
    document.querySelector('.announcement-edit-' + id).style.display = 'none';
}
</script>w