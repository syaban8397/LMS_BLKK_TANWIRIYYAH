<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Create User
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Create administrator, instructor, or participant account
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-xl">
                👤 User Management
            </div>

        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- ERROR -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-3xl p-5 shadow-sm">

                <ul class="list-disc list-inside text-red-600 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- PHOTO -->
                <div>

                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

                        <h3 class="font-semibold text-lg text-slate-800 mb-5">
                            Profile Photo
                        </h3>

                        <div class="flex flex-col items-center">

                            <img
                                id="photo-preview"
                                src="https://ui-avatars.com/api/?name=User&size=300"
                                class="w-48 h-48 rounded-2xl object-cover border border-slate-200 shadow-sm">

                            <input
                                type="file"
                                name="photo"
                                accept="image/*"
                                onchange="previewPhoto(event)"
                                class="mt-4 w-full rounded-xl border border-slate-200 p-3 text-sm">

                        </div>

                    </div>

                </div>

                <!-- FORM -->
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

                        <h3 class="font-semibold text-lg text-slate-800 mb-6">
                            User Information
                        </h3>

                        <div class="grid md:grid-cols-2 gap-5">

                            <!-- ROLE -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Role
                                </label>

                                <select
                                    name="role"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="admin">Admin</option>
                                    <option value="instruktur">Instructor</option>
                                    <option value="peserta">Participant</option>

                                </select>
                            </div>

                            <!-- STATUS -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Approval Status
                                </label>

                                <select
                                    name="approval_status"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="approved">Approved</option>
                                    <option value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>

                                </select>
                            </div>

                            <!-- NAME -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- EMAIL -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- PASSWORD -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    NIK
                                </label>

                                <input
                                    type="text"
                                    name="nik"
                                    value="{{ old('nik') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- PHONE -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Phone Number
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- GENDER -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Gender
                                </label>

                                <select
                                    name="gender"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">Select Gender</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Male</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Female</option>

                                </select>
                            </div>

                            <!-- BIRTH PLACE -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Birth Place
                                </label>

                                <input
                                    type="text"
                                    name="birth_place"
                                    value="{{ old('birth_place') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- BIRTH DATE -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Birth Date
                                </label>

                                <input
                                    type="date"
                                    name="birth_date"
                                    value="{{ old('birth_date') }}"
                                    class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- ACTIVE -->
                            <div class="flex items-center mt-8">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="ml-2 text-slate-600">Active User</span>
                            </div>

                        </div>

                        <!-- ADDRESS -->
                        <div class="mt-5">
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Address
                            </label>

                            <textarea
                                name="address"
                                rows="3"
                                class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                        </div>

                        <!-- BIO -->
                        <div class="mt-5">
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Biography
                            </label>

                            <textarea
                                name="bio"
                                rows="5"
                                class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">{{ old('bio') }}</textarea>
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="flex justify-end gap-3 mt-6">

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl transition">

                            Cancel

                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-sm transition">

                            Create User

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <script>
        function previewPhoto(event)
        {
            document.getElementById('photo-preview')
                .src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</x-app-layout>