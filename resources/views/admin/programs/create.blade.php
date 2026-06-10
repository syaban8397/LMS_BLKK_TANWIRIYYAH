<x-app-layout>

<div class="space-y-6">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-blue-800 via-indigo-800 to-slate-900 rounded-3xl p-8 text-white shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold">
                    Create Training Program
                </h1>

                <p class="mt-2 text-blue-100">
                    Add a new training program to the LMS BLKK Tanwiriyyah system.
                </p>

            </div>

        </div>

    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <form action="{{ route('admin.programs.store') }}" method="POST">

            @csrf

            @include('admin.programs.form')

            {{-- ACTION BUTTONS --}}
            <div class="border-t border-slate-200 mt-8 pt-6 flex justify-end gap-3">

                <a href="{{ route('admin.programs.index') }}"
                   class="px-5 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium transition">

                    Cancel

                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-2xl bg-blue-700 hover:bg-blue-800 text-white font-semibold shadow transition">

                    Save Program

                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>