<div class="space-y-4">
    <!-- PROGRAM -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Program <span class="text-red-500">*</span>
        </label>
        <select name="program_id" id="program-select" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="">Pilih program</option>
            @foreach($programs as $program)
                @php
                    $selectedProgramId = old('program_id', $class->program_id ?? '');
                    $isSelected = (string) $selectedProgramId === (string) $program->id;
                    $isFull = $program->classes_count >= $program->capacity && ! $isSelected;
                @endphp
                <option value="{{ $program->id }}"
                        {{ $isSelected ? 'selected' : '' }}
                        {{ $isFull ? 'disabled' : '' }}>
                    {{ $program->name }} ({{ $program->classes_count }}/{{ $program->capacity }} kelas)@if($isFull) — Penuh @endif
                </option>
            @endforeach
        </select>
        <p class="text-xs text-slate-400 mt-1">Program yang sudah penuh tidak dapat dipilih.</p>
        @error('program_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- INSTRUCTOR -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Instructor <span class="text-red-500">*</span>
        </label>
        <select name="instructor_id" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="">Select an instructor</option>
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
            Class Title <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" id="class-title" value="{{ old('title', $class->title ?? '') }}"
               data-original-title="{{ isset($class) ? $class->title : '' }}"
               placeholder="Example: Web Development"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
        @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- CLASS CODE -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Class Code
        </label>
        <input type="text" id="class-code" value="{{ old('code', $class->code ?? '') }}"
               data-current-code="{{ $class->code ?? '' }}"
               data-exclude-id="{{ $class->id ?? '' }}"
               placeholder="Contoh: WEB-0001"
               readonly
               class="input-3d w-full rounded-lg border-slate-200 bg-slate-50 text-slate-600 text-sm px-3 py-2 cursor-not-allowed">
        <p class="text-xs text-slate-400 mt-1">Kode dibuat otomatis dari nama kelas (format: PREFIX-0001).</p>
    </div>

    <!-- DESCRIPTION -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Description
        </label>
        <textarea name="description" rows="3" placeholder="Enter class description..."
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $class->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- DATES -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Start Date <span class="text-red-500">*</span></label>
            <input type="date" name="start_date" value="{{ old('start_date', isset($class) ? $class->start_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('start_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">End Date <span class="text-red-500">*</span></label>
            <input type="date" name="end_date" value="{{ old('end_date', isset($class) ? $class->end_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('end_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- QUOTA & STATUS -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Student Quota</label>
            <input type="number" name="quota" value="{{ old('quota', $class->quota ?? '') }}" placeholder="30" min="1"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('quota')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
            <select name="status" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                <option value="draft" {{ old('status', $class->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ old('status', $class->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $class->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $class->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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