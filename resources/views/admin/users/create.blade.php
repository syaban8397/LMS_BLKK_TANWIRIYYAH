<x-app-layout>
<div class="create-user-wrapper lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.common.create_user')"
            :subtitle="__('lms.common.create_user_subtitle')"
            :back-url="route('admin.users.index')"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--info">{{ __('lms.nav.user_management') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        @if ($errors->any())
            <x-lms-flash type="error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-lms-flash>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid lg:grid-cols-3 gap-5">
                <!-- PHOTO CARD -->
                <div class="card-3d">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 transition-all">
                        <h3 class="font-semibold text-sm text-slate-800 mb-3 flex items-center gap-1">📸 Profile Photo</h3>
                        <div class="flex flex-col items-center">
                            <img id="photo-preview" src="https://ui-avatars.com/api/?name=User&size=120&background=3B82F6&color=fff"
                                 class="w-28 h-28 rounded-xl object-cover border shadow-sm">
                            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)"
                                   class="mt-3 w-full rounded-lg border border-slate-200 p-1.5 text-xs focus:ring-1 focus:ring-blue-400">
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
                                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="instruktur" {{ old('role')=='instruktur' ? 'selected' : '' }}>Instructor</option>
                                    <option value="peserta" {{ old('role')=='peserta' ? 'selected' : '' }}>Participant</option>
                                </select>
                            </div>
                            <!-- Approval Status -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Approval Status</label>
                                <select name="approval_status" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="approved" {{ old('approval_status')=='approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ old('approval_status')=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ old('approval_status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <!-- Full Name -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Password -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Password *</label>
                                <input type="password" name="password" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- NIK -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Phone -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Gender -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Gender</label>
                                <select name="gender" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="">Select</option>
                                    <option value="L" {{ old('gender')=='L' ? 'selected' : '' }}>Male</option>
                                    <option value="P" {{ old('gender')=='P' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <!-- Birth Place -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Place</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Birth Date -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">Birth Date</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Active Checkbox -->
                            <div class="form-group flex items-center mt-2">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400">
                                <span class="ml-2 text-xs text-slate-600">Active User</span>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Address</label>
                            <textarea name="address" rows="1" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('address') }}</textarea>
                        </div>

                        <!-- Biography -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">Biography</label>
                            <textarea name="bio" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('bio') }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-4 pt-2 border-t border-slate-100">
                            <a href="{{ route('admin.users.index') }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-medium transition shadow-sm">Batal</a>
                            <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition shadow-sm hover:shadow-md">Create User</button>
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