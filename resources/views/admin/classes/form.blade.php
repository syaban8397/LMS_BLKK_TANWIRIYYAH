<div class="space-y-4">
    <!-- PROGRAM -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Program <span class="text-red-500">*</span>
        </label>
        <select name="program_id" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="">Select a program</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}" {{ old('program_id', $class->program_id ?? '') == $program->id ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>
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

    <!-- CLASS CODE -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Class Code <span class="text-red-500">*</span>
        </label>
        <input type="text" name="code" value="{{ old('code', $class->code ?? '') }}" placeholder="Example: WEB-101"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
        @error('code')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- CLASS TITLE -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Class Title <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title', $class->title ?? '') }}" placeholder="Example: Introduction to Web Development"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
        @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
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

<style>
    /* Efek 3D pada input (sama dengan gaya sebelumnya) */
    .input-3d {
        transition: all 0.2s ease;
    }
    .input-3d:focus {
        transform: scale(1.01);
        box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
        border-color: #3b82f6;
    }
</style>