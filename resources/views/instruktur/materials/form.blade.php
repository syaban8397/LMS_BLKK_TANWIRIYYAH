<div class="space-y-6">

    <!-- TITLE -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Material Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $material->title ?? '') }}"
            placeholder="Example: Introduction to Web Development"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

        @error('title')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    <!-- DESCRIPTION -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Description
        </label>

        <textarea
            rows="4"
            name="description"
            placeholder="Provide a detailed description of this material..."
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">{{ old('description', $material->description ?? '') }}</textarea>

        @error('description')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    <!-- MEETING NUMBER -->
    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Meeting Number
        </label>

        <input
            type="number"
            name="meeting_number"
            value="{{ old('meeting_number', $material->meeting_number ?? 1) }}"
            placeholder="1"
            min="1"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

        @error('meeting_number')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    <!-- FILE UPLOAD / YOUTUBE SECTION -->
    <div class="bg-slate-50 rounded-2xl p-6 space-y-6">

        <p class="text-sm font-semibold text-slate-700">
            Content (Upload file OR provide YouTube link)
        </p>

        <!-- FILE UPLOAD -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                📎 Upload File
            </label>

            <p class="text-xs text-slate-500 mb-3">
                Supported formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP (Max 100MB)
            </p>

            <input
                type="file"
                name="file"
                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.txt,.jpg,.jpeg,.png,.mp4"
                class="block w-full rounded-2xl border-2 border-dashed border-slate-300 focus:border-blue-500 focus:ring-blue-500 transition px-4 py-6 text-slate-700 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

            @if(isset($material) && $material->file_path)
                <p class="text-sm text-green-600 mt-2">
                    ✓ Current file: {{ $material->file_path }}
                </p>
            @endif

            @error('file')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

        </div>

        <!-- YOUTUBE URL -->
        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                🎥 YouTube URL
            </label>

            <input
                type="url"
                name="youtube_url"
                value="{{ old('youtube_url', $material->youtube_url ?? '') }}"
                placeholder="https://www.youtube.com/watch?v=..."
                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

            @error('youtube_url')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

        </div>

        @error('content')
            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 text-sm">{{ $message }}</p>
            </div>
        @enderror

    </div>

</div>
