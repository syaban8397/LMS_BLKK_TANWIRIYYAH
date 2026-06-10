<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $material->title }}
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Meeting {{ $material->meeting_number }}
                </p>

            </div>

            <div class="flex gap-2">

                <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}"
                   class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl shadow-sm transition">

                    Edit

                </a>

                <a href="{{ route('instruktur.materials.index', $class) }}"
                   class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">

                    Back

                </a>

            </div>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- MATERIAL INFO --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <h3 class="font-bold text-lg text-slate-800 mb-6">
                Material Information
            </h3>

            <div class="space-y-6">

                {{-- TITLE --}}
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">Title</p>
                    <p class="text-slate-800 text-lg font-semibold">{{ $material->title }}</p>
                </div>

                {{-- DESCRIPTION --}}
                @if($material->description)
                    <div>
                        <p class="text-sm text-slate-500 font-medium mb-2">Description</p>
                        <p class="text-slate-700 whitespace-pre-line">{{ $material->description }}</p>
                    </div>
                @endif

                {{-- MEETING --}}
                <div class="grid md:grid-cols-3 gap-6">

                    <div>
                        <p class="text-sm text-slate-500 font-medium mb-1">Meeting</p>
                        <p class="text-slate-800 font-semibold">{{ $material->meeting_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium mb-1">Created By</p>
                        <p class="text-slate-800 font-semibold">{{ $material->creator->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium mb-1">Created At</p>
                        <p class="text-slate-800 font-semibold">{{ $material->created_at->format('d F Y H:i') }}</p>
                    </div>

                </div>

            </div>

        </div>

        {{-- FILE CONTENT --}}
        @if($material->file_path)

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

                <h3 class="font-bold text-lg text-slate-800 mb-6">
                    📎 File
                </h3>

                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200">

                    <div class="flex items-center gap-3">

                        <span class="text-3xl">
                            @switch(strtolower($material->file_type))
                                @case('pdf')
                                    📄
                                    @break
                                @case('doc')
                                @case('docx')
                                    📝
                                    @break
                                @case('xls')
                                @case('xlsx')
                                    📊
                                    @break
                                @case('ppt')
                                @case('pptx')
                                    🎯
                                    @break
                                @case('zip')
                                    📦
                                    @break
                                @case('jpg')
                                @case('jpeg')
                                @case('png')
                                    🖼️
                                    @break
                                @case('mp4')
                                @case('avi')
                                @case('mov')
                                    🎬
                                    @break
                                @default
                                    📎
                            @endswitch
                        </span>

                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ basename($material->file_path) }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ strtoupper($material->file_type) }}
                            </p>
                        </div>

                    </div>

                    <a href="{{ Storage::url($material->file_path) }}"
                       target="_blank"
                       class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">

                        Download

                    </a>

                </div>

            </div>

        @endif

        {{-- YOUTUBE --}}
        @if($material->youtube_url)

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

                <h3 class="font-bold text-lg text-slate-800 mb-6">
                    🎥 YouTube Video
                </h3>

                <div class="aspect-video rounded-2xl overflow-hidden bg-slate-100">

                    @php
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $material->youtube_url, $match);
                        $videoId = $match[1] ?? null;
                    @endphp

                    @if($videoId)

                        <iframe
                            width="100%"
                            height="100%"
                            src="https://www.youtube.com/embed/{{ $videoId }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>

                    @else

                        <div class="w-full h-full flex items-center justify-center text-slate-500">

                            <div class="text-center">

                                <p class="mb-2">Invalid YouTube URL</p>

                                <a href="{{ $material->youtube_url }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline text-sm">

                                    Open in new tab

                                </a>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        @endif

    </div>

</x-app-layout>
