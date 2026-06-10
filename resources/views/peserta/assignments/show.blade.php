<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $assignment->title }}
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $class->title }}
                </p>

            </div>

            <a href="{{ route('peserta.classes.stream', $class) }}"
               class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">

                Back

            </a>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- ASSIGNMENT INFO --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <div class="flex items-start justify-between mb-6">

                <div>

                    <h3 class="font-bold text-lg text-slate-800 mb-2">
                        Assignment Details
                    </h3>

                    <div class="flex flex-wrap gap-4 text-sm">

                        <div>
                            <p class="text-slate-500">By</p>
                            <p class="font-semibold text-slate-800">{{ $assignment->creator->name }}</p>
                        </div>

                        <div>
                            <p class="text-slate-500">Posted</p>
                            <p class="font-semibold text-slate-800">{{ $assignment->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-slate-500">Deadline</p>
                            <p class="font-semibold {{ $assignment->deadline->isFuture() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $assignment->deadline->format('d M Y H:i') }}
                            </p>
                        </div>

                    </div>

                </div>

                @if($assignment->deadline->isFuture())
                    <div class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                        ✓ Active
                    </div>
                @else
                    <div class="px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-medium">
                        ✗ Closed
                    </div>
                @endif

            </div>

            <hr class="my-6">

            <div class="space-y-6">

                <div>
                    <h4 class="font-bold text-slate-800 mb-3">Description</h4>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assignment->description }}</p>
                </div>

                @if($assignment->attachment)

                    <div>
                        <h4 class="font-bold text-slate-800 mb-3">📎 Attachment</h4>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200">

                            <div class="flex items-center gap-3">

                                <span class="text-2xl">📄</span>

                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ basename($assignment->attachment) }}
                                    </p>
                                </div>

                            </div>

                            <a href="{{ Storage::url($assignment->attachment) }}"
                               target="_blank"
                               class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">

                                Download

                            </a>

                        </div>

                    </div>

                @endif

            </div>

        </div>

        {{-- ACTION --}}
        @if($assignment->deadline->isFuture())

            <div class="bg-blue-50 border border-blue-200 rounded-3xl p-8">

                <h3 class="font-bold text-lg text-blue-900 mb-4">
                    📤 Submit Your Work
                </h3>

                <p class="text-blue-800 mb-6">
                    Submit your assignment before the deadline. You can update your submission anytime before the deadline closes.
                </p>

                <button onclick="alert('Submission feature coming soon!')"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-medium transition">

                    Submit Assignment

                </button>

            </div>

        @endif

    </div>

</x-app-layout>
