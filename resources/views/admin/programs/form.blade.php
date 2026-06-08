<div class="space-y-6">

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Program Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $program->name ?? '') }}"
            class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">

        @error('name')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Description
        </label>

        <textarea
            rows="5"
            name="description"
            class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $program->description ?? '') }}</textarea>

    </div>

    <div class="grid md:grid-cols-2 gap-6">

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ old('start_date', isset($program) ? $program->start_date->format('Y-m-d') : '') }}"
                class="w-full rounded-xl border-slate-300">

        </div>

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                End Date
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ old('end_date', isset($program) ? $program->end_date->format('Y-m-d') : '') }}"
                class="w-full rounded-xl border-slate-300">

        </div>

    </div>

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-xl border-slate-300">

            <option value="active">
                Active
            </option>

            <option value="inactive">
                Inactive
            </option>

        </select>

    </div>

</div>