<x-app-layout>
    <div class="h-screen overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="flex-shrink-0 flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-3 px-1">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit User</h2>
                <p class="text-xs text-slate-500">Update user information</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs shadow-md">
                ✏️ Edit Mode
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-2 text-xs mb-3">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="flex-1">
            @csrf
            @method('PUT')
            <div class="grid lg:grid-cols-3 gap-4">
                <!-- PHOTO CARD -->
                <div class="card-3d-wrapper">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <h3 class="font-semibold text-sm text-slate-800 mb-2 flex items-center gap-1">📸 Profile Photo</h3>
                        <div class="flex flex-col items-center">
                            @if($user->photo)
                                <img id="photo-preview" src="{{ asset('storage/'.$user->photo) }}"
                                     class="w-24 h-24 rounded-lg object-cover border shadow-sm">
                            @else
                                <img id="photo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=120&background=3B82F6&color=fff"
                                     class="w-24 h-24 rounded-lg object-cover border shadow-sm">
                            @endif
                            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)"
                                   class="mt-2 w-full rounded-md border border-slate-200 p-1 text-xs focus:ring-1 focus:ring-blue-400">
                            <p class="text-xs text-slate-500 mt-1 text-center">Leave empty if unchanged</p>
                        </div>
                    </div>
                </div>

                <!-- FORM CARD -->
                <div class="lg:col-span-2 card-3d-wrapper">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <h3 class="font-semibold text-sm text-slate-800 mb-3 flex items-center gap-1">📝 User Information</h3>
                        <div class="grid md:grid-cols-2 gap-3">
                            <!-- Role -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Role</label>
                                <select name="role" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                                    <option value="instruktur" @selected(old('role', $user->role) == 'instruktur')>Instructor</option>
                                    <option value="peserta" @selected(old('role', $user->role) == 'peserta')>Participant</option>
                                </select>
                            </div>
                            <!-- Approval Status -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Approval Status</label>
                                <select name="approval_status" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                                    <option value="approved" @selected(old('approval_status', $user->approval_status) == 'approved')>Approved</option>
                                    <option value="pending" @selected(old('approval_status', $user->approval_status) == 'pending')>Pending</option>
                                    <option value="rejected" @selected(old('approval_status', $user->approval_status) == 'rejected')>Rejected</option>
                                </select>
                            </div>
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Password -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">New Password</label>
                                <input type="password" name="password" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                                <span class="text-[10px] text-slate-400">Leave blank if unchanged</span>
                            </div>
                            <!-- NIK -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Phone -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Gender -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Gender</label>
                                <select name="gender" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                                    <option value="">Select</option>
                                    <option value="L" @selected(old('gender', $user->gender) == 'L')>Male</option>
                                    <option value="P" @selected(old('gender', $user->gender) == 'P')>Female</option>
                                </select>
                            </div>
                            <!-- Birth Place -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Place</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Birth Date -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Date</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}" class="input-3d w-full rounded-md border-slate-200 text-xs py-1.5">
                            </div>
                            <!-- Active Checkbox -->
                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active)) class="w-3.5 h-3.5 rounded border-slate-300 text-blue-600">
                                <span class="ml-1 text-xs text-slate-600">Active User</span>
                            </div>
                        </div>

                        <!-- Address - 1 baris -->
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Address</label>
                            <textarea name="address" rows="1" class="input-3d w-full rounded-md border-slate-200 text-xs py-1">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Biography - 2 baris -->
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Biography</label>
                            <textarea name="bio" rows="2" class="input-3d w-full rounded-md border-slate-200 text-xs py-1">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end gap-2 mt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn-3d px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-md text-xs shadow-md transition">Cancel</a>
                            <button type="submit" class="btn-3d px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs shadow-md transition">Update User</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* Sama persis dengan style Create User */
        .h-screen {
            height: 100vh;
            overflow: hidden;
        }
        form {
            overflow-y: auto;
            scrollbar-width: none;
        }
        form::-webkit-scrollbar {
            display: none;
        }
        .card-3d-wrapper {
            overflow: visible;
        }
        .card-3d-wrapper > div {
            transition: all 0.2s ease;
        }
        .card-3d-wrapper:hover > div {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
        }
        .input-3d {
            transition: all 0.2s ease;
        }
        .input-3d:focus {
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
            border-color: #3b82f6;
            transform: scale(1.01);
        }
        .btn-3d {
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>

    <script>
        function previewPhoto(event) {
            const preview = document.getElementById('photo-preview');
            if (event.target.files && event.target.files[0]) {
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>