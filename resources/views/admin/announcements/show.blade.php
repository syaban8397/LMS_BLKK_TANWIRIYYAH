<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="'Pengumuman — ' . $class->title"
            :subtitle="$class->code . ' · Instruktur: ' . $class->instructor->name"
            :back-url="route('admin.announcements.index')"
        >
            <x-slot:actions>
                <a href="{{ route('admin.classes.show', $class) }}" class="lms-btn-secondary btn-3d">Detail Kelas</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        @if ($errors->any())
            <x-lms-flash type="error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-lms-flash>
        @endif

        {{-- Form tambah pengumuman --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span>📢</span> Buat Pengumuman Baru
            </h3>
            <form action="{{ route('admin.announcements.store', $class) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Judul pengumuman..." required
                           class="w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" placeholder="Tulis pengumuman untuk kelas ini..." required
                              class="w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Publikasikan
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar pengumuman --}}
        <div class="space-y-4">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <span>📋</span> Daftar Pengumuman ({{ $announcements->count() }})
            </h3>

            @forelse($announcements as $announcement)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5" id="announcement-{{ $announcement->id }}">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                {{ strtoupper(substr($announcement->creator?->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $announcement->creator?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $announcement->created_at->format('d M Y H:i') }}
                                    ·
                                    @if($announcement->creator?->role === 'admin')
                                        <span class="text-purple-600 font-medium">Admin</span>
                                    @else
                                        <span class="text-blue-600 font-medium">Instruktur</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="showEditForm({{ $announcement->id }})"
                                    class="px-3 py-1 text-xs bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.announcements.destroy', [$class, $announcement]) }}" method="POST"
                                  data-lms-confirm="Hapus pengumuman ini?" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="announcement-view-{{ $announcement->id }} mt-4">
                        <h4 class="font-bold text-slate-800">{{ $announcement->title }}</h4>
                        <p class="text-slate-600 text-sm mt-2 whitespace-pre-line">{{ $announcement->description }}</p>
                    </div>

                    <div class="announcement-edit-{{ $announcement->id }} mt-4" style="display:none;">
                        <form action="{{ route('admin.announcements.update', [$class, $announcement]) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $announcement->title }}"
                                   class="w-full rounded-lg border-slate-200 text-sm px-3 py-2">
                            <textarea name="description" rows="4"
                                      class="w-full rounded-lg border-slate-200 text-sm px-3 py-2">{{ $announcement->description }}</textarea>
                            <div class="flex gap-2">
                                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs">Simpan</button>
                                <button type="button" onclick="cancelEdit({{ $announcement->id }})"
                                        class="px-3 py-1.5 bg-slate-200 rounded-md text-xs">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center text-slate-400 text-sm">
                    Belum ada pengumuman di kelas ini.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function showEditForm(id) {
            document.querySelector('.announcement-view-' + id).style.display = 'none';
            document.querySelector('.announcement-edit-' + id).style.display = 'block';
        }
        function cancelEdit(id) {
            document.querySelector('.announcement-view-' + id).style.display = 'block';
            document.querySelector('.announcement-edit-' + id).style.display = 'none';
        }
    </script>
</x-app-layout>
