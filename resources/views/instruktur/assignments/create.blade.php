<x-app-layout>
<div class="create-assignment-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Buat Tugas"
            :subtitle="'Tambah tugas baru untuk ' . $class->title"
            :back-url="route('instruktur.classes.stream', $class)"
            back-label="← Kembali ke Stream"
        />

        @if ($errors->any())
            <x-lms-flash type="error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-lms-flash>
        @endif

        {{-- Form Card --}}
        <div class="form-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
            <form action="{{ route('instruktur.assignments.store', $class) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Title --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Assignment Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" placeholder="e.g., Essay on Web Development" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" placeholder="Detailed description of the assignment..." required
                              class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2"></textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Attachment (File) --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attachment (Optional)</label>
                    <div class="upload-area relative border-2 border-dashed border-slate-300 rounded-lg hover:border-blue-400 transition cursor-pointer bg-slate-50/50">
                        <input type="file" name="attachment" id="attachment_input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center py-6 px-4">
                            <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500">Click or drag to upload a file</p>
                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, PPT, ZIP, JPG, PNG (Max 100MB)</p>
                            <div id="file_name_display" class="mt-2 text-xs text-blue-600 font-medium hidden"></div>
                        </div>
                    </div>
                    @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="deadline" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">Ubah deadline untuk memperpanjang waktu pengumpulan</p>
                </div>

                {{-- Late Submission Option --}}
                <div class="form-group">
                    <input type="hidden" name="late_submission_allowed" value="0">
                    <label class="checkbox-label flex items-start gap-3 cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 transition-all">
                        <input type="checkbox" name="late_submission_allowed" value="1" checked
                               class="w-5 h-5 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mt-0.5">
                        <div class="flex-1">
                            <span class="text-sm font-semibold text-slate-700 block">Allow late submissions</span>
                            <p class="text-xs text-slate-500 mt-1">
                                ✅ If checked: Students can still submit after the deadline. Submissions will be marked as <span class="text-amber-600 font-medium">"Late"</span>.
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                ❌ If unchecked: Students cannot submit after the deadline. Submission form will be completely closed.
                            </p>
                        </div>
                    </label>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Information</p>
                            <p class="text-xs text-blue-700 mt-1">
                                You can change this setting anytime by editing the assignment.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Create Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('attachment_input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const displayDiv = document.getElementById('file_name_display');
            if (file) {
                displayDiv.textContent = 'Selected: ' + file.name;
                displayDiv.classList.remove('hidden');
            } else {
                displayDiv.textContent = '';
                displayDiv.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>