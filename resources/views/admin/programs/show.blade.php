<x-app-layout>

<div class="space-y-6">

    <!-- HERO -->
    <div
        class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-xl">

        <h1 class="text-3xl font-bold">
            {{ $program->name }}
        </h1>

        <p class="text-blue-100 mt-2">
            Training Program Details
        </p>

    </div>

    <!-- DETAIL -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="grid md:grid-cols-2 gap-8">

            <div>

                <h3 class="text-sm text-slate-500 mb-2">
                    Program Name
                </h3>

                <p class="font-semibold text-lg">
                    {{ $program->name }}
                </p>

            </div>

            <div>

                <h3 class="text-sm text-slate-500 mb-2">
                    Status
                </h3>

                @if($program->status == 'active')

                    <span
                        class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                        Active

                    </span>

                @else

                    <span
                        class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

                        Inactive

                    </span>

                @endif

            </div>

            <div>

                <h3 class="text-sm text-slate-500 mb-2">
                    Start Date
                </h3>

                <p>
                    {{ $program->start_date->format('d F Y') }}
                </p>

            </div>

            <div>

                <h3 class="text-sm text-slate-500 mb-2">
                    End Date
                </h3>

                <p>
                    {{ $program->end_date->format('d F Y') }}
                </p>

            </div>

        </div>

        <hr class="my-8">

        <div>

            <h3 class="text-sm text-slate-500 mb-2">
                Description
            </h3>

            <p class="leading-relaxed text-slate-700">
                {{ $program->description }}
            </p>

        </div>

        <hr class="my-8">

        <div class="grid md:grid-cols-3 gap-6">

            <div
                class="bg-blue-50 rounded-2xl p-6">

                <div class="text-sm text-slate-500">
                    Total Classes
                </div>

                <div
                    class="text-3xl font-bold text-blue-700 mt-2">

                    {{ $program->classes()->count() }}

                </div>

            </div>

            <div
                class="bg-green-50 rounded-2xl p-6">

                <div class="text-sm text-slate-500">
                    Created At
                </div>

                <div
                    class="font-semibold text-green-700 mt-2">

                    {{ $program->created_at->format('d M Y') }}

                </div>

            </div>

            <div
                class="bg-purple-50 rounded-2xl p-6">

                <div class="text-sm text-slate-500">
                    Updated At
                </div>

                <div
                    class="font-semibold text-purple-700 mt-2">

                    {{ $program->updated_at->format('d M Y') }}

                </div>

            </div>

        </div>

        <div class="mt-8 flex gap-3">

            <a
                href="{{ route('admin.programs.index') }}"
                class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300">

                Back

            </a>

            <a
                href="{{ route('admin.programs.edit',$program) }}"
                class="px-5 py-3 rounded-xl bg-yellow-500 text-white hover:bg-yellow-600">

                Edit Program

            </a>

        </div>

    </div>

</div>

</x-app-layout>