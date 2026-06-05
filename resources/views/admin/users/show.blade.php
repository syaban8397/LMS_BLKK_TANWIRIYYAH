<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    User Details
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    View complete user information
                </p>

            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('admin.users.edit', $user) }}"
                    class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl">

                    Edit User

                </a>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-xl">

                    Back

                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4">

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- PROFILE CARD -->

                <div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        <div class="flex flex-col items-center">

                            @if($user->photo)

                                <img
                                    src="{{ asset('storage/'.$user->photo) }}"
                                    class="w-48 h-48 rounded-3xl object-cover border">

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=300"
                                    class="w-48 h-48 rounded-3xl">

                            @endif

                            <h3 class="mt-5 text-2xl font-bold text-gray-800">

                                {{ $user->name }}

                            </h3>

                            <p class="text-gray-500">

                                {{ $user->email }}

                            </p>

                            <div class="flex flex-wrap justify-center gap-2 mt-5">

                                <!-- ROLE -->

                                @if($user->role == 'admin')

                                    <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                        Admin
                                    </span>

                                @elseif($user->role == 'instruktur')

                                    <span class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                        Instructor
                                    </span>

                                @else

                                    <span class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                        Participant
                                    </span>

                                @endif

                                <!-- APPROVAL -->

                                @if($user->approval_status == 'approved')

                                    <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                        Approved
                                    </span>

                                @elseif($user->approval_status == 'rejected')

                                    <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                        Rejected
                                    </span>

                                @else

                                    <span class="px-4 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                        Pending
                                    </span>

                                @endif

                                <!-- ACTIVE -->

                                @if($user->is_active)

                                    <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                        Active
                                    </span>

                                @else

                                    <span class="px-4 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                        Inactive
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                <!-- DETAIL -->

                <div class="lg:col-span-2">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        <h3 class="text-lg font-semibold mb-6">
                            Personal Information
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div>

                                <label class="text-sm text-gray-500">
                                    Full Name
                                </label>

                                <div class="font-medium mt-1">
                                    {{ $user->name ?: '-' }}
                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Email Address
                                </label>

                                <div class="font-medium mt-1">
                                    {{ $user->email ?: '-' }}
                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    NIK
                                </label>

                                <div class="font-medium mt-1">
                                    {{ $user->nik ?: '-' }}
                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Phone Number
                                </label>

                                <div class="font-medium mt-1">
                                    {{ $user->phone ?: '-' }}
                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Gender
                                </label>

                                <div class="font-medium mt-1">

                                    @if($user->gender == 'L')

                                        Male

                                    @elseif($user->gender == 'P')

                                        Female

                                    @else

                                        -

                                    @endif

                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Birth Place
                                </label>

                                <div class="font-medium mt-1">
                                    {{ $user->birth_place ?: '-' }}
                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Birth Date
                                </label>

                                <div class="font-medium mt-1">

                                    {{ $user->birth_date
                                        ? $user->birth_date->format('d F Y')
                                        : '-' }}

                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Account Status
                                </label>

                                <div class="font-medium mt-1">

                                    {{ $user->is_active ? 'Active' : 'Inactive' }}

                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Approval Status
                                </label>

                                <div class="font-medium mt-1 capitalize">

                                    {{ $user->approval_status ?: '-' }}

                                </div>

                            </div>

                            <div>

                                <label class="text-sm text-gray-500">
                                    Registered At
                                </label>

                                <div class="font-medium mt-1">

                                    {{ $user->created_at->format('d F Y H:i') }}

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- ADDRESS -->

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">

                        <h3 class="text-lg font-semibold mb-4">
                            Address
                        </h3>

                        <p class="text-gray-700 leading-relaxed">

                            {{ $user->address ?: 'No address available.' }}

                        </p>

                    </div>

                    <!-- BIO -->

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">

                        <h3 class="text-lg font-semibold mb-4">
                            Biography
                        </h3>

                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">

                            {{ $user->bio ?: 'No biography available.' }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>