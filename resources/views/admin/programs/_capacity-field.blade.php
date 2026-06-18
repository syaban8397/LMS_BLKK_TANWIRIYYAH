<div class="input-group">
    <label class="block text-xs font-medium text-slate-500 mb-1">
        {{ __('lms.common.class_capacity') }} <span class="text-red-500">*</span>
    </label>
    <input type="number" name="capacity"
           value="{{ old('capacity', $program->capacity ?? 1) }}"
           min="1" max="999" required
           placeholder="{{ __('lms.common.capacity_placeholder') }}"
           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
    <p class="text-xs text-slate-400 mt-1">{{ __('lms.common.capacity_hint') }}</p>
    @error('capacity')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
