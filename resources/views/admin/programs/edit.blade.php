<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Create Training Program
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Add a new training program to the LMS BLKK Tanwiriyyah system.
                </p>
            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

            <form action="{{ route('admin.programs.store') }}" method="POST">

                @csrf

                @include('admin.programs.form')

                <div class="border-t border-slate-200 mt-8 pt-6 flex justify-end gap-3">

                    <a href="{{ route('admin.programs.index') }}"
                       class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition">

                        Cancel

                    </a>

                    <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">

                        Save Program

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>