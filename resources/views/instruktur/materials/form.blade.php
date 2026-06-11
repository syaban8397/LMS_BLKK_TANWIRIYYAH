<div class="space-y-5">
    {{-- TITLE --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Material Title</label>
        <input type="text" name="title" value="{{ old('title', $material->title ?? '') }}" placeholder="Example: Introduction to Web Development"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- DESCRIPTION --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Description</label>
        <textarea name="description" rows="4" placeholder="Provide a detailed description of this material..."
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('description', $material->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- MEETING NUMBER --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Meeting Number</label>
        <input type="number" name="meeting_number" value="{{ old('meeting_number', $material->meeting_number ?? 1) }}" min="1"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('meeting_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- CONTENT SECTION (FILE / YOUTUBE) --}}
    <div class="border-t border-slate-200 pt-4 mt-2">
        <p class="text-sm font-semibold text-slate-700 mb-3">Content (Upload file OR provide YouTube link)</p>

        <div class="space-y-5">
            {{-- FILE UPLOAD --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">📎 Upload File</label>
                <p class="text-xs text-slate-400 mb-2">Supported: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, JPG, PNG, MP4 (Max 100MB)</p>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.txt,.jpg,.jpeg,.png,.mp4"
                       class="file-input-3d block w-full rounded-lg border-2 border-dashed border-slate-300 focus:border-blue-400 focus:ring-blue-400 transition text-sm px-3 py-2 cursor-pointer">
                @if(isset($material) && $material->file_path)
                    <p class="text-xs text-emerald-600 mt-1">✓ Current file: {{ basename($material->file_path) }}</p>
                @endif
                @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- YOUTUBE URL --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">🎥 YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $material->youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=..."
                       class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
                @error('youtube_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        @error('content')
            <div class="mt-3 p-2 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 text-xs">{{ $message }}</p>
            </div>
        @enderror
    </div>
</div>

<style>
    .input-3d {
        transition: all 0.2s ease;
    }
    .input-3d:focus {
        transform: scale(1.01);
        box-shadow: 0 0 0 2px rgba(59,130,246,0.1);
        border-color: #3b82f6;
        outline: none;
    }
    .file-input-3d {
        transition: all 0.2s ease;
    }
    .file-input-3d:focus {
        transform: scale(1.01);
        border-color: #3b82f6;
        outline: none;
    }
</style>