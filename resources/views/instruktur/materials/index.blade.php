<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $class->title }} - Materials
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Manage learning materials for this class.
                </p>

            </div>

            <div class="flex gap-2">

                <a href="{{ route('instruktur.materials.create', $class) }}"
                   class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-sm transition">

                    + New Material

                </a>

                <a href="{{ route('instruktur.classes.stream', $class) }}"
                   class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">

                    Back

                </a>

            </div>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>

        @endif

        {{-- MATERIALS --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-200">

                <h3 class="font-bold text-slate-800">
                    Materials ({{ $materials->total() }})
                </h3>

            </div>

            @if($materials->count() > 0)

                {{-- LIST --}}
                <div class="divide-y divide-slate-100">

                    @foreach($materials as $material)

                        <div class="p-6 hover:bg-slate-50 transition">

                            <div class="flex items-start justify-between gap-4">

                                {{-- CONTENT --}}
                                <div class="flex-1 min-w-0">

                                    {{-- MEETING NUMBER BADGE --}}
                                    <div class="mb-3">
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                            Meeting {{ $material->meeting_number }}
                                        </span>
                                    </div>

                                    {{-- TITLE --}}
                                    <h4 class="font-bold text-slate-800 mb-2 break-words">
                                        {{ $material->title }}
                                    </h4>

                                    {{-- DESCRIPTION --}}
                                    @if($material->description)
                                        <p class="text-sm text-slate-600 mb-3 line-clamp-2">
                                            {{ $material->description }}
                                        </p>
                                    @endif

                                    {{-- CONTENT TYPE --}}
                                    <div class="flex flex-wrap gap-3 text-xs">

                                        @if($material->file_path)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-lg">
                                                📎 {{ strtoupper($material->file_type) }}
                                            </span>
                                        @endif

                                        @if($material->youtube_url)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-lg">
                                                🎥 YouTube
                                            </span>
                                        @endif

                                    </div>

                                </div>

                                {{-- ACTIONS --}}
                                <div class="flex gap-2 flex-shrink-0">

                                    <a href="{{ route('instruktur.materials.show', [$class, $material]) }}"
                                       class="px-3 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-sm transition">

                                        View

                                    </a>

                                    <a href="{{ route('instruktur.materials.edit', [$class, $material]) }}"
                                       class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm transition">

                                        Edit

                                    </a>

                                    <form action="{{ route('instruktur.materials.destroy', [$class, $material]) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Are you sure?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm transition">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="p-4">
                    {{ $materials->links() }}
                </div>

            @else

                <div class="p-8 text-center text-slate-500">

                    <p class="text-lg">No materials added yet.</p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
