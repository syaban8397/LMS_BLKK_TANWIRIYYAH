<div class="space-y-4">
    <!-- PROGRAM -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            {{ __('lms.report.program') }} <span class="text-red-500">*</span>
        </label>
        <select name="program_id" id="program-select" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="">{{ __('lms.common.select_program') }}</option>
            @foreach($programs as $program)
                @php
                    $selectedProgramId = old('program_id', $class->program_id ?? '');
                    $isSelected = (string) $selectedProgramId === (string) $program->id;
                    $isFull = $program->classes_count >= $program->capacity && ! $isSelected;
                @endphp
                <option value="{{ $program->id }}"
                        {{ $isSelected ? 'selected' : '' }}
                        {{ $isFull ? 'disabled' : '' }}>
                    {{ $program->name }} ({{ __('lms.common.classes_slot', ['current' => $program->classes_count, 'max' => $program->capacity]) }})@if($isFull) — {{ __('lms.common.full') }} @endif
                </option>
            @endforeach
        </select>
        <p class="text-xs text-slate-400 mt-1">{{ __('lms.common.program_full_hint') }}</p>
        @error('program_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- INSTRUCTOR -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            {{ __('lms.report.instructor') }} <span class="text-red-500">*</span>
        </label>
        <select name="instructor_id" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="">{{ __('lms.common.select_instructor') }}</option>
            @foreach($instructors as $instructor)
                <option value="{{ $instructor->id }}" {{ old('instructor_id', $class->instructor_id ?? '') == $instructor->id ? 'selected' : '' }}>
                    {{ $instructor->name }}
                </option>
            @endforeach
        </select>
        @error('instructor_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- CLASS TITLE -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            {{ __('lms.common.class_title') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" id="class-title" value="{{ old('title', $class->title ?? '') }}"
               data-original-title="{{ isset($class) ? $class->title : '' }}"
               placeholder="{{ __('lms.common.class_title_ph') }}"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
        @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- CLASS CODE -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            {{ __('lms.common.class_code') }}
        </label>
        <input type="text" id="class-code" value="{{ old('code', $class->code ?? '') }}"
               data-current-code="{{ $class->code ?? '' }}"
               data-exclude-id="{{ $class->id ?? '' }}"
               placeholder="{{ __('lms.common.class_code_ph') }}"
               readonly
               class="input-3d w-full rounded-lg border-slate-200 bg-slate-50 text-slate-600 text-sm px-3 py-2 cursor-not-allowed">
        <p class="text-xs text-slate-400 mt-1">{{ __('lms.common.code_auto_hint') }}</p>
    </div>

    <!-- DESCRIPTION -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            {{ __('lms.common.description') }}
        </label>
        <textarea name="description" rows="3" placeholder="{{ __('lms.common.class_desc_ph') }}"
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $class->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- DATES -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.start_date') }} <span class="text-red-500">*</span></label>
            <input type="date" name="start_date" value="{{ old('start_date', isset($class) ? $class->start_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('start_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.end_date') }} <span class="text-red-500">*</span></label>
            <input type="date" name="end_date" value="{{ old('end_date', isset($class) ? $class->end_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('end_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- CLASS SCHEDULE -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.class_start_time') }} <span class="text-red-500">*</span></label>
            <input type="time" name="start_time" value="{{ old('start_time', isset($class) ? \Illuminate\Support\Str::substr($class->start_time ?? '08:00:00', 0, 5) : '08:00') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('start_time')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.class_duration_minutes') }} <span class="text-red-500">*</span></label>
            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $class->duration_minutes ?? 60) }}" min="1" max="480"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('duration_minutes')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- QUOTA & STATUS -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.student_quota') }}</label>
            <input type="number" name="quota" value="{{ old('quota', $class->quota ?? '') }}" placeholder="30" min="1"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('quota')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.status') }}</label>
            <select name="status" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                <option value="draft" {{ old('status', $class->status ?? '') == 'draft' ? 'selected' : '' }}>{{ __('lms.common.draft') }}</option>
                <option value="active" {{ old('status', $class->status ?? '') == 'active' ? 'selected' : '' }}>{{ __('lms.active') }}</option>
                <option value="completed" {{ old('status', $class->status ?? '') == 'completed' ? 'selected' : '' }}>{{ __('lms.common.completed') }}</option>
                <option value="cancelled" {{ old('status', $class->status ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('lms.common.cancelled') }}</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('class-title');
        const codeInput = document.getElementById('class-code');

        if (!titleInput || !codeInput) {
            return;
        }

        const previewUrl = @json(route('admin.classes.preview-code'));
        const originalTitle = titleInput.dataset.originalTitle || '';
        const currentCode = codeInput.dataset.currentCode || '';
        const excludeId = codeInput.dataset.excludeId || '';
        let timeoutId;

        function updateClassCodePreview() {
            const title = titleInput.value.trim();

            if (!title) {
                codeInput.value = '';
                return;
            }

            if (originalTitle && title === originalTitle && currentCode) {
                codeInput.value = currentCode;
                return;
            }

            clearTimeout(timeoutId);
            timeoutId = setTimeout(function () {
                const params = new URLSearchParams({
                    title: title,
                });

                if (excludeId) {
                    params.append('exclude_id', excludeId);
                }

                fetch(previewUrl + '?' + params.toString(), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        codeInput.value = data.code || '';
                    })
                    .catch(function () {
                        codeInput.value = '';
                    });
            }, 300);
        }

        titleInput.addEventListener('input', updateClassCodePreview);
        updateClassCodePreview();
    });
</script>
