<div class="space-y-5">
    {{-- TITLE --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.material.title') }}</label>
        <input type="text" name="title" value="{{ old('title', $material->title ?? '') }}" placeholder="{{ __('lms.material.title_ph') }}"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- MATERIAL CODE --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.material.code') }}</label>
        <input type="text" name="material_code" value="{{ old('material_code', $material->material_code ?? '') }}"
               placeholder="{{ __('lms.material.code_ph') }}"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('material_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.common.description') }}</label>
        <textarea name="description" rows="4" placeholder="{{ __('lms.material.desc_ph') }}"
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('description', $material->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- MEETING NUMBER --}}
    <div class="form-group">
        <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.material.meeting_number') }}</label>
        <input type="number" name="meeting_number" value="{{ old('meeting_number', $material->meeting_number ?? 1) }}" min="1"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">
        @error('meeting_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- CONTENT SECTION (FILE / YOUTUBE) --}}
    <div class="form-group border-t border-slate-200 pt-4 mt-2">
        <p class="text-sm font-semibold text-slate-700 mb-3">{{ __('lms.material.content') }}</p>

        <div class="space-y-5">
            {{-- FILE UPLOAD --}}
            <div class="file-group">
                <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.material.upload_file') }}</label>
                <p class="text-xs text-slate-400 mb-2">{{ __('lms.material.file_types_hint') }}</p>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.txt,.jpg,.jpeg,.png,.mp4"
                       class="file-input-3d block w-full rounded-lg border-2 border-dashed border-slate-300 focus:border-blue-400 focus:ring-blue-400 transition text-sm px-3 py-2 cursor-pointer">
                @if(isset($material) && $material->file_path)
                    <p class="text-xs text-emerald-600 mt-1">{{ __('lms.material.current_file', ['name' => basename($material->file_path)]) }}</p>
                @endif
                @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- YOUTUBE URL --}}
            <div class="youtube-group">
                <label class="block text-xs font-semibold text-slate-600 mb-1">{{ __('lms.material.youtube_url') }}</label>
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
