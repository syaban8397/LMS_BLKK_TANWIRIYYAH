<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $class->title }}
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Class code: <span class="font-semibold">{{ $class->code }}</span>
                </p>

            </div>

            <a href="{{ route('peserta.classes.index') }}"
               class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">

                Back

            </a>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- CLASS INFORMATION --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <h3 class="font-bold text-lg text-slate-800 mb-6">
                Class Information
            </h3>

            <div class="grid md:grid-cols-2 gap-8">

                {{-- LEFT COLUMN --}}
                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Program</p>
                        <p class="text-slate-800 font-semibold">{{ $class->program->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Instructor</p>
                        <p class="text-slate-800 font-semibold">{{ $class->instructor->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Enrollment Status</p>
                        <p class="text-slate-800 font-semibold">
                            @switch($participation->status)
                                @case('active')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                        Active
                                    </span>
                                    @break

                                @case('completed')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                        Completed
                                    </span>
                                    @break

                                @case('dropped')
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                                        Dropped
                                    </span>
                                    @break
                            @endswitch
                        </p>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Start Date</p>
                        <p class="text-slate-800 font-semibold">{{ $class->start_date->format('d F Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium">End Date</p>
                        <p class="text-slate-800 font-semibold">{{ $class->end_date->format('d F Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Enrolled At</p>
                        <p class="text-slate-800 font-semibold">{{ $participation->enrolled_at?->format('d F Y') ?? '-' }}</p>
                    </div>

                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-6 pt-6 border-t border-slate-200">

                <p class="text-sm text-slate-500 font-medium mb-2">Description</p>

                <p class="text-slate-700">
                    {{ $class->description }}
                </p>

            </div>

        </div>

        {{-- CLASS CONTENT TABS --}}
        <div class="grid md:grid-cols-4 gap-4">

            <a href="{{ route('peserta.materials.index', $class) }}"
               class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-6 shadow-sm text-white hover:shadow-md transition">

                <div class="text-4xl mb-3">📖</div>

                <h4 class="font-bold text-lg">Learning Materials</h4>

                <p class="text-blue-100 text-sm mt-2">
                    View course materials and resources
                </p>

            </a>

            <a href="#"
               class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-3xl p-6 shadow-sm text-white hover:shadow-md transition">

                <div class="text-4xl mb-3">📝</div>

                <h4 class="font-bold text-lg">Assignments</h4>

                <p class="text-purple-100 text-sm mt-2">
                    Submit your assignments here
                </p>

            </a>

            <a href="#"
               class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-3xl p-6 shadow-sm text-white hover:shadow-md transition">

                <div class="text-4xl mb-3">📅</div>

                <h4 class="font-bold text-lg">Attendance</h4>

                <p class="text-amber-100 text-sm mt-2">
                    Mark your attendance
                </p>

            </a>

            <a href="#"
               class="bg-gradient-to-br from-green-500 to-green-600 rounded-3xl p-6 shadow-sm text-white hover:shadow-md transition">

                <div class="text-4xl mb-3">🎯</div>

                <h4 class="font-bold text-lg">My Grades</h4>

                <p class="text-green-100 text-sm mt-2">
                    Check your grades and progress
                </p>

                <a href="#"
                   class="mt-4 inline-block px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm transition">

                    View →

                </a>

            </div>

        </div>

        {{-- ANNOUNCEMENTS PREVIEW --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <h3 class="font-bold text-lg text-slate-800 mb-6">
                Latest Announcements
            </h3>

            <div class="text-center py-8 text-slate-500">

                <p class="text-sm">
                    No announcements yet. Check back soon!
                </p>

            </div>

        </div>

    </div>

</x-app-layout>
