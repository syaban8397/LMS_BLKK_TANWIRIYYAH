@php
    $selectedType = old('submission_type', $assignment->submission_type ?? 'file_and_link');
@endphp

<div class="form-group">
    <label class="block text-xs font-medium text-slate-500 mb-2">{{ __('lms.assignment.submission_type_label') }} <span class="text-red-500">*</span></label>
    <div class="flex flex-wrap gap-2">
        @foreach([
            'file' => __('lms.assignment.submission_type_file'),
            'link' => __('lms.assignment.submission_type_link'),
            'file_and_link' => __('lms.assignment.submission_type_both'),
        ] as $value => $label)
            <label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer text-sm transition {{ $selectedType === $value ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-200 hover:border-blue-300' }}">
                <input type="radio" name="submission_type" value="{{ $value }}" class="text-blue-600 focus:ring-blue-500" {{ $selectedType === $value ? 'checked' : '' }} required>
                {{ $label }}
            </label>
        @endforeach
    </div>
    @error('submission_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    <p class="text-xs text-slate-400 mt-1">{{ __('lms.assignment.submission_type_hint') }}</p>
</div>
