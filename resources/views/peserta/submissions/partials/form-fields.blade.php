@php
    $type = $assignment->submission_type ?? 'file_and_link';
    $showFile = in_array($type, ['file', 'file_and_link'], true);
    $showLink = in_array($type, ['link', 'file_and_link'], true);
@endphp

@if($showFile)
    <div class="form-group">
        <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
            <x-lms-icon name="upload" class="w-4 h-4" />
            {{ __('lms.assignment.upload_file') }}
            @if($type === 'file')<span class="text-red-500">*</span>@endif
        </label>
        <input type="file" name="file" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all cursor-pointer" {{ $type === 'file' ? 'required' : '' }}>
        @if(isset($submission) && $submission->file_path)
            <p class="text-xs text-emerald-600 mt-1">{{ __('lms.assignment.current_file', ['name' => basename($submission->file_path)]) }}</p>
        @endif
        @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        <p class="text-xs text-slate-400 mt-1">{{ __('lms.assignment.file_max_hint') }}</p>
    </div>
@endif

@if($showLink)
    <div class="form-group">
        <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
            <x-lms-icon name="link" class="w-4 h-4" />
            {{ __('lms.assignment.url_label') }}
            @if($type === 'link')<span class="text-red-500">*</span>@endif
        </label>
        <input type="url" name="url" value="{{ old('url', $submission->url ?? '') }}" placeholder="https://..." class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all" {{ $type === 'link' ? 'required' : '' }}>
        @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
@endif

<div class="form-group">
    <label class="block text-sm font-semibold text-slate-700 mb-2 inline-flex items-center gap-1">
        <x-lms-icon name="edit" class="w-4 h-4" />
        {{ __('lms.attendance.notes_optional') }}
    </label>
    <textarea name="notes" rows="4" placeholder="{{ __('lms.assignment.notes_ph') }}" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $submission->notes ?? '') }}</textarea>
</div>
