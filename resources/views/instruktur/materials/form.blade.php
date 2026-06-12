<div class="space-y-5">
    {{-- TITLE --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">Material Title</label>
        <input type="text" name="title" value="{{ old('title', $material->title ?? '') }}" placeholder="Example: Introduction to Web Development"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">Description</label>
        <textarea name="description" rows="4" placeholder="Provide a detailed description of this material..."
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('description', $material->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- MEETING NUMBER --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">Meeting Number</label>
        <input type="number" name="meeting_number" value="{{ old('meeting_number', $material->meeting_number ?? 1) }}" min="1"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('meeting_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- CONTENT SECTION (FILE / YOUTUBE) --}}
    <div class="form-group border-t border-slate-200 pt-4 mt-2">
        <p class="text-sm font-semibold text-slate-700 mb-3">Content (Upload file OR provide YouTube link)</p>

        <div class="space-y-5">
            {{-- FILE UPLOAD --}}
            <div class="file-group">
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
            <div class="youtube-group">
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
    /* Efek 3D pada setiap group */
    .form-group, .file-group, .youtube-group {
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        transform-style: preserve-3d;
        transform: translateY(0) rotateX(0);
    }
    .form-group:hover, .file-group:hover, .youtube-group:hover {
        transform: translateY(-4px) rotateX(2deg);
        box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.1);
    }

    /* Input field 3D dengan efek lebih tajam */
    .input-3d {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        transform: translateY(0) scale(1);
    }
    .input-3d:focus {
        transform: translateY(-2px) scale(1.02) rotateX(1deg);
        box-shadow: 0 10px 20px -8px rgba(59, 130, 246, 0.3);
        border-color: #3b82f6;
        outline: none;
    }

    /* File input 3D */
    .file-input-3d {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        transform: translateY(0);
        background: #f8fafc;
    }
    .file-input-3d:hover {
        transform: translateY(-2px);
        background: #f1f5f9;
        border-color: #3b82f6;
    }
    .file-input-3d:focus {
        transform: translateY(-2px) scale(1.01);
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    /* Label efek 3D */
    label {
        transition: all 0.2s ease;
        display: inline-block;
    }
    .form-group:hover label, .file-group:hover label, .youtube-group:hover label {
        transform: translateX(4px);
        color: #1e40af;
    }

</style>