<x-app-layout>
<div class="peserta-submission-edit-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Edit Pengumpulan"
            :subtitle="$assignment->title . ' — ' . $class->title"
            :back-url="route('peserta.assignments.show', [$class, $assignment])"
        />

        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        {{-- Form Card (3D) --}}
        <div class="form-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Submission
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Update your work before deadline</p>
            </div>
            <div class="p-5">
                <form action="{{ route('peserta.submissions.update', [$class, $assignment, $submission]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">📎 Upload New File</label>
                        <input type="file" name="file" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all cursor-pointer">
                        @if($submission->file_path)
                            <p class="text-xs text-emerald-600 mt-1">✓ Current file: {{ basename($submission->file_path) }}</p>
                        @endif
                        @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">🔗 URL (Google Drive, GitHub, etc.)</label>
                        <input type="url" name="url" value="{{ old('url', $submission->url) }}" placeholder="https://..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
                        @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">📝 Notes (Optional)</label>
                        <textarea name="notes" rows="4" placeholder="Add any additional notes..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $submission->notes) }}</textarea>
                        @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Deadline Reminder --}}
                    <div class="form-group bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                        <div class="flex items-start gap-2">
                            <span class="text-yellow-600 text-lg">⏰</span>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800">Deadline Reminder</p>
                                <p class="text-xs text-yellow-700 mt-0.5">Submission deadline: <span class="font-bold">{{ $assignment->deadline->format('d M Y H:i') }}</span></p>
                                <p class="text-xs text-yellow-600 mt-1">You can edit your submission until the deadline passes.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Batal</a>
                        <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">Update Submission</button>
                    </div>
                </form>

                {{-- Delete Form --}}
                <div class="form-group mt-6 pt-4 border-t border-slate-200">
                    <form action="{{ route('peserta.submissions.destroy', [$class, $assignment, $submission]) }}" method="POST" data-lms-confirm="Delete your submission permanently? This action cannot be undone.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-link text-red-600 text-sm hover:text-red-700 transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete Submission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>