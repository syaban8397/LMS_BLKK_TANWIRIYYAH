<x-app-layout>

<div class="space-y-6">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-blue-800 via-indigo-800 to-slate-900 rounded-3xl p-8 text-white shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold">
                    {{ $user->name }}
                </h1>

                <p class="mt-2 text-blue-100">
                    User Profile & Account Information
                </p>

            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.users.edit',$user) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 px-5 py-3 rounded-2xl text-white font-semibold shadow">

                    Edit User

                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="bg-white text-slate-900 px-5 py-3 rounded-2xl font-semibold hover:bg-slate-100 shadow">

                    Back

                </a>

            </div>

        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- PROFILE CARD --}}
        <div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <div class="flex flex-col items-center">

                    @if($user->photo)

                        <img src="{{ asset('storage/'.$user->photo) }}"
                             class="w-48 h-48 rounded-3xl object-cover border">

                    @else

                        <div class="w-48 h-48 rounded-3xl bg-gradient-to-r from-blue-700 to-indigo-700 flex items-center justify-center text-white text-6xl font-bold">

                            {{ strtoupper(substr($user->name,0,1)) }}

                        </div>

                    @endif

                    <h2 class="mt-6 text-2xl font-bold text-slate-800">
                        {{ $user->name }}
                    </h2>

                    <p class="text-slate-500">
                        {{ $user->email }}
                    </p>

                    <div class="flex flex-wrap justify-center gap-2 mt-5">

                        @if($user->role == 'admin')
                            <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm">Admin</span>
                        @elseif($user->role == 'instruktur')
                            <span class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Instructor</span>
                        @else
                            <span class="px-4 py-1 bg-slate-100 text-slate-700 rounded-full text-sm">Participant</span>
                        @endif

                        @if($user->approval_status == 'approved')
                            <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm">Approved</span>
                        @elseif($user->approval_status == 'rejected')
                            <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm">Rejected</span>
                        @else
                            <span class="px-4 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Pending</span>
                        @endif

                    </div>

                </div>

            </div>

            {{-- ACCOUNT STATUS --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mt-6">

                <h3 class="font-bold text-slate-800 mb-4">
                    Account Status
                </h3>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold text-slate-800">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Role</span>
                        <span class="font-semibold text-slate-800">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Registered</span>
                        <span class="font-semibold text-slate-800">
                            {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

        {{-- DETAIL --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- PERSONAL INFO --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <h3 class="text-xl font-bold text-slate-800 mb-6">
                    Personal Information
                </h3>

                <div class="grid md:grid-cols-2 gap-6 text-sm">

                    <div>
                        <p class="text-slate-500">Full Name</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $user->name ?: '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Email Address</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $user->email ?: '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">NIK</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $user->nik ?: '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Phone Number</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $user->phone ?: '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Gender</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            @if($user->gender == 'L')
                                Male
                            @elseif($user->gender == 'P')
                                Female
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Birth Place</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $user->birth_place ?: '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Birth Date</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            {{ $user->birth_date ? $user->birth_date->format('d F Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Approval Status</p>
                        <p class="font-semibold text-slate-800 mt-1 capitalize">
                            {{ $user->approval_status }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- ADDRESS --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    Address
                </h3>

                <p class="text-slate-700 leading-relaxed">
                    {{ $user->address ?: 'No address available.' }}
                </p>

            </div>

            {{-- BIO --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    Biography
                </h3>

                <p class="text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $user->bio ?: 'No biography available.' }}
                </p>

            </div>

        </div>

    </div>

</div>

</x-app-layout>