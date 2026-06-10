<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Classes
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Manage all classes available in the LMS.
                </p>

            </div>

            <a href="{{ route('admin.classes.create') }}"
               class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-sm transition">

                + New Class

            </a>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>

        @endif

        {{-- STATS --}}
        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                <p class="text-slate-500 text-sm">
                    Total Classes
                </p>

                <h3 class="text-4xl font-bold text-blue-700 mt-2">
                    {{ $totalClasses }}
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                <p class="text-slate-500 text-sm">
                    Active Classes
                </p>

                <h3 class="text-4xl font-bold text-green-600 mt-2">
                    {{ $activeClasses }}
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                <p class="text-slate-500 text-sm">
                    Draft Classes
                </p>

                <h3 class="text-4xl font-bold text-amber-600 mt-2">
                    {{ $draftClasses }}
                </h3>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-200">

                <h3 class="font-bold text-slate-800">
                    Class List
                </h3>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 text-slate-600 text-sm">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                Class
                            </th>

                            <th class="px-6 py-4 text-left">
                                Program
                            </th>

                            <th class="px-6 py-4 text-left">
                                Instructor
                            </th>

                            <th class="px-6 py-4 text-center">
                                Period
                            </th>

                            <th class="px-6 py-4 text-center">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($classes as $class)

                            <tr class="border-t hover:bg-slate-50 transition">

                                {{-- CLASS --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-800">
                                        {{ $class->title }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        {{ $class->code }}
                                    </div>

                                </td>

                                {{-- PROGRAM --}}
                                <td class="px-6 py-4 text-slate-700 text-sm">
                                    {{ $class->program->name }}
                                </td>

                                {{-- INSTRUCTOR --}}
                                <td class="px-6 py-4 text-slate-700 text-sm">
                                    {{ $class->instructor->name }}
                                </td>

                                {{-- PERIOD --}}
                                <td class="px-6 py-4 text-center text-slate-700 text-sm">

                                    {{ $class->start_date->format('d M Y') }}
                                    -
                                    {{ $class->end_date->format('d M Y') }}

                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 text-center">

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

                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.classes.show', $class) }}"
                                           class="px-3 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-sm transition">

                                            View

                                        </a>

                                        <a href="{{ route('admin.classes.edit', $class) }}"
                                           class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm transition">

                                            Edit

                                        </a>

                                        <form action="{{ route('admin.classes.destroy', $class) }}"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this class?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm transition">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">

                                    No classes found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="p-4">
                {{ $classes->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
