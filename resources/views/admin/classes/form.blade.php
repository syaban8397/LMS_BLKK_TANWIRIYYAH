<div class="space-y-6">

    <!-- PROGRAM -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Program
        </label>

        <select
            name="program_id"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            <option value="">
                Select a program
            </option>

            @foreach($programs as $program)

                <option value="{{ $program->id }}"
                    {{ old('program_id', $class->program_id ?? '') == $program->id ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>

            @endforeach

        </select>

        @error('program_id')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>

    <!-- INSTRUCTOR -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Instructor
        </label>

        <select
            name="instructor_id"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            <option value="">
                Select an instructor
            </option>

            @foreach($instructors as $instructor)

                <option value="{{ $instructor->id }}"
                    {{ old('instructor_id', $class->instructor_id ?? '') == $instructor->id ? 'selected' : '' }}>
                    {{ $instructor->name }}
                </option>

            @endforeach

        </select>

        @error('instructor_id')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>

    <!-- CLASS CODE -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Class Code
        </label>

        <input
            type="text"
            name="code"
            value="{{ old('code', $class->code ?? '') }}"
            placeholder="Example: WEB-101"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

        @error('code')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>

    <!-- CLASS TITLE -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Class Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $class->title ?? '') }}"
            placeholder="Example: Introduction to Web Development"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

        @error('title')
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
            placeholder="Enter class description..."
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">{{ old('description', $class->description ?? '') }}</textarea>

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
                value="{{ old('start_date', isset($class) ? $class->start_date->format('Y-m-d') : '') }}"
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
                value="{{ old('end_date', isset($class) ? $class->end_date->format('Y-m-d') : '') }}"
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            @error('end_date')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

    </div>

    <!-- QUOTA & STATUS -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- QUOTA -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Student Quota
            </label>

            <input
                type="number"
                name="quota"
                value="{{ old('quota', $class->quota ?? '') }}"
                placeholder="Example: 30"
                min="1"
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            @error('quota')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- STATUS -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Status
            </label>

            <select
                name="status"
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

                <option value="draft"
                    {{ old('status', $class->status ?? '') == 'draft' ? 'selected' : '' }}>
                    Draft
                </option>

                <option value="active"
                    {{ old('status', $class->status ?? '') == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="completed"
                    {{ old('status', $class->status ?? '') == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>

                <option value="cancelled"
                    {{ old('status', $class->status ?? '') == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>

            </select>

            @error('status')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

    </div>

</div>
