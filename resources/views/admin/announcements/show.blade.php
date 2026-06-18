<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.admin_page.announcements_title', ['title' => $class->title])"
            :subtitle="__('lms.admin_page.instructor_line', ['code' => $class->code, 'name' => $class->instructor->name])"
            :back-url="route('admin.announcements.index')"
        >
            <x-slot:actions>
                <a href="{{ route('admin.classes.show', $class) }}" class="lms-btn-secondary">{{ __('lms.admin_page.class_detail_btn') }}</a>
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
                <span>📢</span> {{ __('lms.admin_page.create_announcement') }}
            </h3>
            <form action="{{ route('admin.announcements.store', $class) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.admin_page.title_label') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('lms.common.announcement_title_ph') }}" required
                           class="w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.admin_page.body_label') }} <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" placeholder="{{ __('lms.admin_page.body_ph') }}" required
                              class="w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="lms-btn-primary">
                        {{ __('lms.admin_page.publish') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar pengumuman --}}
        <div class="space-y-4">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <span>📋</span> {{ __('lms.admin_page.announcement_list', ['count' => $announcements->count()]) }}
            </h3>

            @forelse($announcements as $announcement)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5" id="announcement-{{ $announcement->id }}">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                {{ strtoupper(substr($announcement->creator?->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $announcement->creator?->name ?? __('lms.admin_page.unknown') }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $announcement->created_at->format('d M Y H:i') }}
                                    ·
                                    @if($announcement->creator?->role === 'admin')
                                        <span class="text-purple-600 font-medium">{{ __('lms.roles.admin') }}</span>
                                    @else
                                        <span class="text-blue-600 font-medium">{{ __('lms.roles.instruktur') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="showEditForm({{ $announcement->id }})"
                                    class="px-3 py-1 text-xs bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition">
                                {{ __('lms.edit') }}
                            </button>
                            <form action="{{ route('admin.announcements.destroy', [$class, $announcement]) }}" method="POST"
                                  data-lms-confirm="{{ __('lms.admin_page.delete_announcement_confirm') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">
                                    {{ __('lms.delete') }}
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
                                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs">{{ __('lms.save') }}</button>
                                <button type="button" onclick="cancelEdit({{ $announcement->id }})"
                                        class="px-3 py-1.5 bg-slate-200 rounded-md text-xs">{{ __('lms.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center text-slate-400 text-sm">
                    {{ __('lms.admin_page.no_announcements_class') }}
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
