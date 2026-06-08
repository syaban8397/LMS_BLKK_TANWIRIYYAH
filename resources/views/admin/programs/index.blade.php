<x-app-layout>

<div class="space-y-6">

    <!-- HERO -->
    <div
        class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-xl">

        <div class="flex justify-between items-center">

            <div>

                <h1 class="text-3xl font-bold">
                    Training Programs
                </h1>

                <p class="text-blue-100 mt-2">
                    Manage all BLKK training programs.
                </p>

            </div>

            <a
                href="{{ route('admin.programs.create') }}"
                class="bg-white text-blue-800 px-5 py-3 rounded-xl font-semibold hover:bg-blue-50">

                + New Program

            </a>

        </div>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))

        <div
            class="bg-green-100 border border-green-200 text-green-700 rounded-2xl p-4">

            {{ session('success') }}

        </div>

    @endif

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-6">

        <div
            class="bg-white rounded-3xl p-6 shadow-lg">

            <div class="text-slate-500">
                Total Programs
            </div>

            <div
                class="text-3xl font-bold text-blue-700 mt-2">

                {{ $totalPrograms }}

            </div>

        </div>

        <div
            class="bg-white rounded-3xl p-6 shadow-lg">

            <div class="text-slate-500">
                Active Programs
            </div>

            <div
                class="text-3xl font-bold text-green-600 mt-2">

                {{ $activePrograms }}

            </div>

        </div>

        <div
            class="bg-white rounded-3xl p-6 shadow-lg">

            <div class="text-slate-500">
                Inactive Programs
            </div>

            <div
                class="text-3xl font-bold text-red-600 mt-2">

                {{ $inactivePrograms }}

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div
        class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div
            class="p-6 border-b border-slate-200">

            <h2
                class="text-lg font-bold text-slate-800">

                Program List

            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead
                    class="bg-slate-50">

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
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($programs as $program)

                    <tr
                        class="border-t hover:bg-slate-50">

                        <td class="px-6 py-4">

                            <div
                                class="font-semibold text-slate-800">

                                {{ $program->name }}

                            </div>

                            <div
                                class="text-sm text-slate-500 mt-1">

                                {{ Str::limit($program->description,80) }}

                            </div>

                        </td>

                        <td class="px-6 py-4 text-center">

                            {{ $program->start_date->format('d M Y') }}

                            <br>

                            <span class="text-slate-400">
                                to
                            </span>

                            <br>

                            {{ $program->end_date->format('d M Y') }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($program->status == 'active')

                                <span
                                    class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">

                                    Active

                                </span>

                            @else

                                <span
                                    class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            {{ $program->classes()->count() }}

                        </td>

                        <td class="px-6 py-4">

                            <div
                                class="flex justify-center gap-2">

                                <a
                                    href="{{ route('admin.programs.show',$program) }}"
                                    class="px-3 py-2 bg-sky-500 text-white rounded-lg">

                                    Detail

                                </a>

                                <a
                                    href="{{ route('admin.programs.edit',$program) }}"
                                    class="px-3 py-2 bg-yellow-500 text-white rounded-lg">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('admin.programs.destroy',$program) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this program?')"
                                        class="px-3 py-2 bg-red-600 text-white rounded-lg">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="py-12 text-center text-slate-500">

                            No programs found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-6">

            {{ $programs->links() }}

        </div>

    </div>

</div>

</x-app-layout>