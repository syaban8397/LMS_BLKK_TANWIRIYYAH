<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Edit Assignment
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Update assignment information
                </p>

            </div>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <form action="{{ route('instruktur.assignments.update', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <!-- TITLE -->
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Assignment Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $assignment->title) }}"
                            required
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
                            rows="6"
                            name="description"
                            required
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">{{ old('description', $assignment->description) }}</textarea>

                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- ATTACHMENT -->
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            📎 Attachment (Optional)
                        </label>

                        <input
                            type="file"
                            name="attachment"
                            class="block w-full rounded-2xl border-2 border-dashed border-slate-300 focus:border-blue-500 px-4 py-6 text-slate-700 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                        @if($assignment->attachment)
                            <p class="text-sm text-green-600 mt-2">
                                ✓ Current: {{ basename($assignment->attachment) }}
                            </p>
                        @endif

                        @error('attachment')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- DEADLINE -->
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            📅 Deadline
                        </label>

                        <input
                            type="datetime-local"
                            name="deadline"
                            value="{{ old('deadline', $assignment->deadline->format('Y-m-d\TH:i')) }}"
                            required
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">

                        @error('deadline')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="border-t border-slate-200 mt-8 pt-6 flex justify-end gap-3">

                    <a href="{{ route('instruktur.classes.stream', $class) }}"
                       class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition">

                        Cancel

                    </a>

                    <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">

                        Update Assignment

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
