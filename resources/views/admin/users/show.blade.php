<x-app-layout>
<div class="show-user-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            :title="$user->name"
            subtitle="User Profile & Account Information"
            :back-url="route('admin.users.index')"
        >
            <x-slot:actions>
                <a href="{{ route('admin.users.edit', $user) }}" class="lms-btn-warning btn-3d">✏️ Edit User</a>
            </x-slot:actions>
        </x-lms-page-header>

        {{-- Main Grid --}}
        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Profile Card (ukuran sedang) --}}
            <div class="card-3d">
                <div class="bg-white rounded-xl border border-slate-200 shadow-md p-5 transition-all">
                    <div class="flex flex-col items-center">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" 
                                 class="w-32 h-32 rounded-xl object-cover border shadow-sm">
                        @else
                            <div class="w-32 h-32 rounded-xl bg-gradient-to-r from-slate-500 to-slate-600 flex items-center justify-center text-white text-4xl font-bold shadow-sm">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                        @endif
                        <h2 class="mt-4 text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        <div class="flex flex-wrap justify-center gap-2 mt-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'instruktur' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if($user->approval_status == 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Approved</span>
                            @elseif($user->approval_status == 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Rejected</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Pending</span>
                            @endif
                        </div>
                    </div>

                    {{-- Account Status --}}
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Account Status</h3>
                        <div class="grid grid-cols-3 gap-3 text-sm">
                            <div>
                                <span class="text-slate-400 text-xs">Status</span>
                                <p class="font-medium text-slate-800">{{ $user->is_active ? 'Active' : 'Inactive' }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs">Role</span>
                                <p class="font-medium text-slate-800 capitalize">{{ $user->role }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs">Registered</span>
                                <p class="font-medium text-slate-800">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Information (kolom kanan) --}}
            <div class="lg:col-span-2 space-y-5">
                {{-- Personal Information --}}
                <div class="card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-md p-5 transition-all">
                        <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <span>👤</span> Personal Information
                        </h3>
                        <div class="grid md:grid-cols-2 gap-x-5 gap-y-3 text-sm">
                            <div><span class="text-slate-400 text-xs">Full Name</span><p class="font-medium text-slate-800">{{ $user->name ?: '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">Email Address</span><p class="font-medium text-slate-800">{{ $user->email ?: '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">NIK</span><p class="font-medium text-slate-800">{{ $user->nik ?: '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">Phone Number</span><p class="font-medium text-slate-800">{{ $user->phone ?: '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">Gender</span><p class="font-medium text-slate-800">@if($user->gender == 'L') Male @elseif($user->gender == 'P') Female @else - @endif</p></div>
                            <div><span class="text-slate-400 text-xs">Birth Place</span><p class="font-medium text-slate-800">{{ $user->birth_place ?: '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">Birth Date</span><p class="font-medium text-slate-800">{{ $user->birth_date ? $user->birth_date->format('d M Y') : '-' }}</p></div>
                            <div><span class="text-slate-400 text-xs">Approval Status</span><p class="font-medium text-slate-800 capitalize">{{ $user->approval_status }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-md p-5 transition-all">
                        <h3 class="text-base font-semibold text-slate-800 mb-2 flex items-center gap-2">📍 Address</h3>
                        <p class="text-sm text-slate-600">{{ $user->address ?: 'No address available.' }}</p>
                    </div>
                </div>

                {{-- Biography --}}
                <div class="card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-md p-5 transition-all">
                        <h3 class="text-base font-semibold text-slate-800 mb-2 flex items-center gap-2">📝 Biography</h3>
                        <p class="text-sm text-slate-600 whitespace-pre-line">{{ $user->bio ?: 'No biography available.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>