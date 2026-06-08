<x-app-layout>

<div class="space-y-6">

    <!-- HERO -->
    <div
        class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-xl">

        <h1 class="text-3xl font-bold">
            Edit Training Program
        </h1>

        <p class="text-blue-100 mt-2">
            Update program information.
        </p>

    </div>

    <!-- FORM -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form
            action="{{ route('admin.programs.update',$program) }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('admin.programs.form')

            <div class="mt-8 flex gap-3">

                <a
                    href="{{ route('admin.programs.index') }}"
                    class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 transition">

                    Back

                </a>

                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl bg-yellow-500 text-white hover:bg-yellow-600 transition">

                    Update Program

                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>