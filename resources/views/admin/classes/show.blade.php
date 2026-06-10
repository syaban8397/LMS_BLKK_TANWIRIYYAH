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

            <div class="flex gap-2">

                <a href="{{ route('admin.classes.edit', $class) }}"
                   class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl shadow-sm transition">

                    Edit

                </a>

                <a href="{{ route('admin.classes.index') }}"
                   class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">

                    Back

                </a>

            </div>

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
                        <p class="text-sm text-slate-500 font-medium">Class Code</p>
                        <p class="text-slate-800 font-semibold">{{ $class->code }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 font-medium">Student Quota</p>
                        <p class="text-slate-800 font-semibold">{{ $class->quota }}</p>
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
                        <p class="text-sm text-slate-500 font-medium">Status</p>
                        <p class="text-slate-800 font-semibold">
                            @switch($class->status)
                                @case('draft')
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">
                                        Draft
                                    </span>
                                    @break

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

                                @case('cancelled')
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                                        Cancelled
                                    </span>
                                    @break
                            @endswitch
                        </p>
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

        {{-- ENROLLED STUDENTS --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-200">

                <h3 class="font-bold text-slate-800">
                    Enrolled Students ({{ $class->participants->count() }}/{{ $class->quota }})
                </h3>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 text-slate-600 text-sm">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                Name
                            </th>

                            <th class="px-6 py-4 text-left">
                                Email
                            </th>

                            <th class="px-6 py-4 text-center">
                                Enrolled At
                            </th>

                            <th class="px-6 py-4 text-center">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($class->participants as $participant)

                            <tr class="border-t hover:bg-slate-50 transition">

                                <td class="px-6 py-4 text-slate-800 font-medium">
                                    {{ $participant->participant->name }}
                                </td>

                                <td class="px-6 py-4 text-slate-600 text-sm">
                                    {{ $participant->participant->email }}
                                </td>

                                <td class="px-6 py-4 text-center text-slate-700 text-sm">
                                    {{ $participant->enrolled_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @switch($participant->status)
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

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">

                                    No students enrolled yet.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
