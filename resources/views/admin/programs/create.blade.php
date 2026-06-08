<x-app-layout>

<div class="space-y-6">

    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-xl">

        <h1 class="text-3xl font-bold">
            Create Training Program
        </h1>

        <p class="text-blue-100 mt-2">
            Add a new BLKK training program.
        </p>

    </div>

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form action="{{ route('admin.programs.store') }}"
              method="POST">

            @csrf

            @include('admin.programs.form')

            <div class="mt-8 flex gap-3">

                <a href="{{ route('admin.programs.index') }}"
                   class="px-5 py-3 rounded-xl bg-slate-200">
                    Back
                </a>

                <button
                    class="px-5 py-3 rounded-xl bg-blue-600 text-white">
                    Save Program
                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>