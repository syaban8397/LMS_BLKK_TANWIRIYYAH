<x-app-layout>
<div class="peserta-submission-create-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Kumpulkan Tugas"
            :subtitle="$assignment->title . ' — ' . $class->title"
            :back-url="route('peserta.assignments.show', [$class, $assignment])"
        />

        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
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

        {{-- Form Card (3D) --}}
        <div class="form-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Submission Form
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Upload your work or provide a link</p>
            </div>
            <div class="p-5">
                <form action="{{ route('peserta.submissions.store', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">📎 Upload File</label>
                        <input type="file" name="file" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all cursor-pointer">
                        @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-slate-400 mt-1">Max 20MB (PDF, DOC, DOCX, ZIP, etc.)</p>
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">🔗 URL (Google Drive, GitHub, etc.)</label>
                        <input type="url" name="url" placeholder="https://..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
                        @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">📝 Notes (Optional)</label>
                        <textarea name="notes" rows="4" placeholder="Add any additional notes for the instructor..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all"></textarea>
                    </div>

                    {{-- Deadline Warning --}}
                    <div class="form-group bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                        <div class="flex items-start gap-2">
                            <span class="text-yellow-600 text-lg">⚠️</span>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800">Deadline Information</p>
                                <p class="text-xs text-yellow-700 mt-0.5">Submit before: <span class="font-bold">{{ $assignment->deadline->format('d M Y H:i') }}</span></p>
                                <p class="text-xs text-yellow-600 mt-1">Late submissions may be accepted but will be marked as "Late".</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Batal</a>
                        <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Submit Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>