<div class="space-y-6">

    <!-- PROGRAM NAME -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Program Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $program->name ?? '') }}"
            placeholder="Example: Web Development Training"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

        @error('name')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>

    <!-- DESCRIPTION -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Description
        </label>

        <textarea
            rows="5"
            name="description"
            placeholder="Enter training program description..."
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">{{ old('description', $program->description ?? '') }}</textarea>

        @error('description')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>

    <!-- DATES -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- START DATE -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ old('start_date', isset($program) ? $program->start_date->format('Y-m-d') : '') }}"
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            @error('start_date')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- END DATE -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                End Date
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ old('end_date', isset($program) ? $program->end_date->format('Y-m-d') : '') }}"
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            @error('end_date')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

    </div>

    <!-- STATUS -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Program Status
        </label>

        <select
            name="status"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            <option value="active"
                {{ old('status',$program->status ?? '') == 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive"
                {{ old('status',$program->status ?? '') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

</div>