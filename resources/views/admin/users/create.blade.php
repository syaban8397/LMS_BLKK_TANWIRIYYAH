<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Create User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Create administrator, instructor, or participant account
            </p>
        </div>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4">

            @if ($errors->any())

                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">

                    <ul class="list-disc list-inside text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('admin.users.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="grid lg:grid-cols-3 gap-6">

                    <!-- PHOTO -->

                    <div>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                            <h3 class="font-semibold text-lg mb-5">
                                Profile Photo
                            </h3>

                            <div class="flex flex-col items-center">

                                <img
                                    id="photo-preview"
                                    src="https://ui-avatars.com/api/?name=User&size=300"
                                    class="w-48 h-48 rounded-2xl object-cover border">

                                <input
                                    type="file"
                                    name="photo"
                                    accept="image/*"
                                    onchange="previewPhoto(event)"
                                    class="mt-4 w-full border rounded-xl p-3">

                            </div>

                        </div>

                    </div>

                    <!-- FORM -->

                    <div class="lg:col-span-2">

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                            <h3 class="font-semibold text-lg mb-6">
                                User Information
                            </h3>

                            <div class="grid md:grid-cols-2 gap-5">

                                <!-- ROLE -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Role
                                    </label>

                                    <select
                                        name="role"
                                        class="w-full rounded-xl border-gray-300">

                                        <option value="admin">
                                            Admin
                                        </option>

                                        <option value="instruktur">
                                            Instructor
                                        </option>

                                        <option value="peserta">
                                            Participant
                                        </option>

                                    </select>

                                </div>

                                <!-- STATUS -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Approval Status
                                    </label>

                                    <select
                                        name="approval_status"
                                        class="w-full rounded-xl border-gray-300">

                                        <option value="approved">
                                            Approved
                                        </option>

                                        <option value="pending">
                                            Pending
                                        </option>

                                        <option value="rejected">
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                                <!-- NAME -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- EMAIL -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- PASSWORD -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- NIK -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        NIK
                                    </label>

                                    <input
                                        type="text"
                                        name="nik"
                                        value="{{ old('nik') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- PHONE -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- GENDER -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Gender
                                    </label>

                                    <select
                                        name="gender"
                                        class="w-full rounded-xl border-gray-300">

                                        <option value="">
                                            Select Gender
                                        </option>

                                        <option
                                            value="L"
                                            {{ old('gender') == 'L' ? 'selected' : '' }}>
                                            Male
                                        </option>

                                        <option
                                            value="P"
                                            {{ old('gender') == 'P' ? 'selected' : '' }}>
                                            Female
                                        </option>

                                    </select>

                                </div>

                                <!-- BIRTH PLACE -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Birth Place
                                    </label>

                                    <input
                                        type="text"
                                        name="birth_place"
                                        value="{{ old('birth_place') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- BIRTH DATE -->

                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Birth Date
                                    </label>

                                    <input
                                        type="date"
                                        name="birth_date"
                                        value="{{ old('birth_date') }}"
                                        class="w-full rounded-xl border-gray-300">

                                </div>

                                <!-- ACTIVE -->

                                <div class="flex items-center mt-8">

                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        checked>

                                    <span class="ml-2">
                                        Active User
                                    </span>

                                </div>

                            </div>

                            <!-- ADDRESS -->

                            <div class="mt-5">

                                <label class="block text-sm font-medium mb-2">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    rows="3"
                                    class="w-full rounded-xl border-gray-300">{{ old('address') }}</textarea>

                            </div>

                            <!-- BIO -->

                            <div class="mt-5">

                                <label class="block text-sm font-medium mb-2">
                                    Biography
                                </label>

                                <textarea
                                    name="bio"
                                    rows="5"
                                    class="w-full rounded-xl border-gray-300">{{ old('bio') }}</textarea>

                            </div>

                        </div>

                        <div class="flex justify-end gap-3 mt-6">

                            <a
                                href="{{ route('admin.users.index') }}"
                                class="px-6 py-3 bg-gray-200 rounded-xl">

                                Cancel

                            </a>

                            <button
                                type="submit"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl">

                                Create User

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>
        function previewPhoto(event)
        {
            document.getElementById('photo-preview')
                .src = URL.createObjectURL(
                    event.target.files[0]
                );
        }
    </script>

</x-app-layout>