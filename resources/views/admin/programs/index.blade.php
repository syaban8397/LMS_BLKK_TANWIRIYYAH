<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Training Programs
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Manage all training programs available in the LMS.
                </p>

            </div>

            <a href="{{ route('admin.programs.create') }}"
               class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-sm transition">

                + New Program

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
                    Total Programs
                </p>

                <h3 class="text-4xl font-bold text-blue-700 mt-2">
                    {{ $totalPrograms }}
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                <p class="text-slate-500 text-sm">
                    Active Programs
                </p>

                <h3 class="text-4xl font-bold text-green-600 mt-2">
                    {{ $activePrograms }}
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                <p class="text-slate-500 text-sm">
                    Inactive Programs
                </p>

                <h3 class="text-4xl font-bold text-red-600 mt-2">
                    {{ $inactivePrograms }}
                </h3>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-200">

                <h3 class="font-bold text-slate-800">
                    Program List
                </h3>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 text-slate-600 text-sm">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                Program
                            </th>

                            <th class="px-6 py-4 text-center">
                                Period
                            </th>

                            <th class="px-6 py-4 text-center">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center">
                                Classes
                            </th>

                            <th class="px-6 py-4 text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($programs as $program)

                            <tr class="border-t hover:bg-slate-50 transition">

                                {{-- PROGRAM --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-800">
                                        {{ $program->name }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        {{ Str::limit($program->description,80) }}
                                    </div>

                                </td>

                                {{-- PERIOD --}}
                                <td class="px-6 py-4 text-center text-slate-700 text-sm">

                                    {{ $program->start_date->format('d M Y') }}
                                    -
                                    {{ $program->end_date->format('d M Y') }}

                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 text-center">

                                    @if($program->status == 'active')

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                            Active
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                {{-- CLASS COUNT --}}
                                <td class="px-6 py-4 text-center text-slate-700 font-medium">

                                    {{ $program->classes()->count() }}

                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.programs.show',$program) }}"
                                           class="px-3 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-sm transition">

                                            View

                                        </a>

                                        <a href="{{ route('admin.programs.edit',$program) }}"
                                           class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm transition">

                                            Edit

                                        </a>

                                        <form action="{{ route('admin.programs.destroy',$program) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Delete this program?')"
                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm transition">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-12 text-slate-500">

                                    No training programs available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="p-6 border-t border-slate-100">

                {{ $programs->links() }}

            </div>

        </div>

    </div>

</x-app-layout>