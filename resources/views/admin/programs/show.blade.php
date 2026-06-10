<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Program Details
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    View complete information about the training program.
                </p>

            </div>

        </div>

    </x-slot>

    <div class="space-y-6">

        <!-- HERO -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        {{ $program->name }}
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Training Program Overview
                    </p>

                </div>

                <!-- STATUS -->
                <div>

                    @if($program->status == 'active')

                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                            Active
                        </span>

                    @else

                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <!-- STATISTICS -->
        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-500 text-sm">Total Classes</p>
                <h3 class="text-4xl font-bold text-blue-700 mt-2">
                    {{ $program->classes()->count() }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-500 text-sm">Created At</p>
                <h3 class="text-lg font-semibold text-green-700 mt-2">
                    {{ $program->created_at->format('d M Y') }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-500 text-sm">Last Updated</p>
                <h3 class="text-lg font-semibold text-purple-700 mt-2">
                    {{ $program->updated_at->format('d M Y') }}
                </h3>
            </div>

        </div>

        <!-- PROGRAM INFORMATION (RESTORED) -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <h3 class="text-lg font-bold text-slate-800 mb-6">
                Program Information
            </h3>

            <div class="grid md:grid-cols-2 gap-8">

                <div>
                    <label class="block text-sm text-slate-500 mb-2">Program Name</label>
                    <div class="text-slate-800 font-semibold">
                        {{ $program->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-500 mb-2">Program Status</label>
                    <div class="font-semibold">
                        {{ ucfirst($program->status) }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-500 mb-2">Start Date</label>
                    <div class="text-slate-800">
                        {{ $program->start_date->format('d F Y') }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-500 mb-2">End Date</label>
                    <div class="text-slate-800">
                        {{ $program->end_date->format('d F Y') }}
                    </div>
                </div>

            </div>

        </div>

        <!-- DESCRIPTION -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <h3 class="text-lg font-bold text-slate-800 mb-6">
                Program Description
            </h3>

            <div class="text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $program->description }}
            </div>

        </div>

        <!-- ACTION -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex flex-wrap gap-3">

                <a
                    href="{{ route('admin.programs.edit',$program) }}"
                    class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition">

                    Edit Program

                </a>

                <form
                    action="{{ route('admin.programs.destroy',$program) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Delete this training program?')"
                        class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition">

                        Delete Program

                    </button>

                </form>

                <a
                    href="{{ route('admin.programs.index') }}"
                    class="px-5 py-3 bg-slate-200 hover:bg-slate-300 rounded-xl transition">

                    Back to Programs

                </a>

            </div>

        </div>

    </div>

</x-app-layout>