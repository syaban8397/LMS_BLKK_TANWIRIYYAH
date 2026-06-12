<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        /* Animasi untuk setiap card */
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        /* Animasi untuk setiap group input */
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Wrapper utama */
        .edit-user-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
            height: 100%;
            overflow-y: auto;
            scrollbar-width: thin;
            padding: 1rem;
        }

        /* Card 3D */
        .card-3d {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .card-3d:hover {
            transform: translateY(-5px) rotateX(1deg) rotateY(1deg);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        /* Grup form */
        .form-group {
            animation: fadeSlideUp 0.4s ease forwards;
            opacity: 0;
        }
        /* Stagger delay untuk setiap field */
        .form-group:nth-child(1) { animation-delay: 0.05s; }
        .form-group:nth-child(2) { animation-delay: 0.1s; }
        .form-group:nth-child(3) { animation-delay: 0.15s; }
        .form-group:nth-child(4) { animation-delay: 0.2s; }
        .form-group:nth-child(5) { animation-delay: 0.25s; }
        .form-group:nth-child(6) { animation-delay: 0.3s; }
        .form-group:nth-child(7) { animation-delay: 0.35s; }
        .form-group:nth-child(8) { animation-delay: 0.4s; }
        .form-group:nth-child(9) { animation-delay: 0.45s; }
        .form-group:nth-child(10) { animation-delay: 0.5s; }
        .form-group:nth-child(11) { animation-delay: 0.55s; }
        .form-group:nth-child(12) { animation-delay: 0.6s; }
        .form-group:nth-child(13) { animation-delay: 0.65s; }

        /* Input 3D */
        .input-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .input-3d:focus {
            transform: scale(1.01) translateZ(3px);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            border-color: #3b82f6;
            outline: none;
        }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Custom scroll */
        .edit-user-wrapper::-webkit-scrollbar {
            width: 5px;
        }
        .edit-user-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .edit-user-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>

    <div class="edit-user-wrapper">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit User</h2>
                <p class="text-xs text-slate-500">Update user information</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs shadow-md">
                ✏️ Edit Mode
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-2 text-xs mb-4 animate-pulse">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid lg:grid-cols-3 gap-5">
                <!-- PHOTO CARD -->
                <div class="card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 transition-all">
                        <h3 class="font-semibold text-sm text-slate-800 mb-3 flex items-center gap-1">📸 Profile Photo</h3>
                        <div class="flex flex-col items-center">
                            @if($user->photo)
                                <img id="photo-preview" src="{{ asset('storage/'.$user->photo) }}"
                                     class="w-28 h-28 rounded-xl object-cover border shadow-sm">
                            @else
                                <img id="photo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=120&background=3B82F6&color=fff"
                                     class="w-28 h-28 rounded-xl object-cover border shadow-sm">
                            @endif
                            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)"
                                   class="mt-3 w-full rounded-lg border border-slate-200 p-1.5 text-xs focus:ring-1 focus:ring-blue-400">
                            <p class="text-xs text-slate-500 mt-2 text-center">Leave empty if unchanged</p>
                        </div>
                    </div>
                </div>

                <!-- FORM CARD -->
                <div class="lg:col-span-2 card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 transition-all">
                        <h3 class="font-semibold text-sm text-slate-800 mb-3 flex items-center gap-1">📝 User Information</h3>
                        <div class="grid md:grid-cols-2 gap-3">
                            <!-- Role -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Role *</label>
                                <select name="role" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="instruktur" {{ old('role', $user->role) == 'instruktur' ? 'selected' : '' }}>Instructor</option>
                                    <option value="peserta" {{ old('role', $user->role) == 'peserta' ? 'selected' : '' }}>Participant</option>
                                </select>
                            </div>
                            <!-- Approval Status -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Approval Status</label>
                                <select name="approval_status" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="approved" {{ old('approval_status', $user->approval_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ old('approval_status', $user->approval_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ old('approval_status', $user->approval_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <!-- Full Name -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Email *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Password -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">New Password</label>
                                <input type="password" name="password" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                <span class="text-[10px] text-slate-400">Leave blank if unchanged</span>
                            </div>
                            <!-- NIK -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Phone -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Gender -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Gender</label>
                                <select name="gender" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="">Select</option>
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Male</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <!-- Birth Place -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Place</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Birth Date -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Date</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Active Checkbox -->
                            <div class="form-group flex items-center mt-2">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400">
                                <span class="ml-2 text-xs text-slate-600">Active User</span>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Address</label>
                            <textarea name="address" rows="1" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Biography -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Biography</label>
                            <textarea name="bio" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4 pt-2 border-t border-slate-100">
                            <a href="{{ route('admin.users.index') }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-medium transition shadow-sm">Cancel</a>
                            <button type="submit" class="btn-3d px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-medium transition shadow-sm hover:shadow-md">Update User</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewPhoto(event) {
            const preview = document.getElementById('photo-preview');
            if (event.target.files && event.target.files[0]) {
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>