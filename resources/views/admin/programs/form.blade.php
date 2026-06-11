<div class="space-y-4">
    <!-- PROGRAM NAME -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Program Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $program->name ?? '') }}" 
               placeholder="Example: Web Development Training"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- DESCRIPTION -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Description
        </label>
        <textarea name="description" rows="3" 
                  placeholder="Enter training program description..."
                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $program->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- DATES -->
    <div class="grid md:grid-cols-2 gap-4">
        <!-- START DATE -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Start Date <span class="text-red-500">*</span>
            </label>
            <input type="date" name="start_date" 
                   value="{{ old('start_date', isset($program) ? $program->start_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('start_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- END DATE -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                End Date <span class="text-red-500">*</span>
            </label>
            <input type="date" name="end_date" 
                   value="{{ old('end_date', isset($program) ? $program->end_date->format('Y-m-d') : '') }}"
                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            @error('end_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- STATUS -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Program Status
        </label>
        <select name="status" 
                class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
            <option value="active" {{ old('status', $program->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $program->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- CAPACITY (optional) -->
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">
            Capacity (optional)
        </label>
        <input type="number" name="capacity" value="{{ old('capacity', $program->capacity ?? '') }}" 
               placeholder="Maximum number of participants"
               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
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