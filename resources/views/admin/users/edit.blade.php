<x-app-layout>
<div class="edit-user-wrapper lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.admin_page.edit_user')"
            :subtitle="__('lms.admin_page.edit_user_subtitle', ['name' => $user->name])"
            :back-url="route('admin.users.show', $user)"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--warning">{{ __('lms.common.edit_mode') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid lg:grid-cols-3 gap-5">
                <!-- PHOTO CARD -->
                <div class="card-3d">
                    <x-lms-form-card :title="__('lms.common.profile_photo')" icon="camera">
                        <div class="flex flex-col items-center">
                            <img id="photo-preview" src="{{ $user->profilePhotoUrl() }}"
                                 class="w-28 h-28 rounded-xl object-cover border shadow-sm" alt="">
                            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)"
                                   class="mt-3 w-full rounded-lg border border-slate-200 p-1.5 text-xs focus:ring-1 focus:ring-blue-400">
                            <p class="text-xs text-slate-500 mt-2 text-center">{{ __('lms.common.leave_blank') }}</p>
                        </div>
                    </x-lms-form-card>
                </div>

                <!-- FORM CARD -->
                <div class="lg:col-span-2 card-3d">
                    <x-lms-form-card :title="__('lms.common.user_information')" icon="edit">
                        <div class="grid md:grid-cols-2 gap-3">
                            <!-- Role -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.role') }} *</label>
                                <select name="role" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>{{ __('lms.roles.admin') }}</option>
                                    <option value="instruktur" {{ old('role', $user->role) == 'instruktur' ? 'selected' : '' }}>{{ __('lms.roles.instruktur') }}</option>
                                    <option value="peserta" {{ old('role', $user->role) == 'peserta' ? 'selected' : '' }}>{{ __('lms.roles.peserta') }}</option>
                                </select>
                            </div>
                            <!-- Approval Status -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.admin_page.approval_status') }}</label>
                                <select name="approval_status" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="approved" {{ old('approval_status', $user->approval_status) == 'approved' ? 'selected' : '' }}>{{ __('lms.common.approved') }}</option>
                                    <option value="pending" {{ old('approval_status', $user->approval_status) == 'pending' ? 'selected' : '' }}>{{ __('lms.common.pending') }}</option>
                                    <option value="rejected" {{ old('approval_status', $user->approval_status) == 'rejected' ? 'selected' : '' }}>{{ __('lms.common.rejected') }}</option>
                                </select>
                            </div>
                            <!-- Full Name -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.full_name') }} *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.email') }} *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                            </div>
                            <!-- Password -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.new_password') }}</label>
                                <input type="password" name="password" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                <span class="text-[10px] text-slate-400">{{ __('lms.common.leave_blank') }}</span>
                            </div>
                            <!-- NIK -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.nik') }}</label>
                                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Phone -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.phone_number') }}</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Gender -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.gender') }}</label>
                                <select name="gender" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    <option value="">{{ __('lms.auth.select') }}</option>
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                                </select>
                            </div>
                            <!-- Birth Place -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.birth_place') }}</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Birth Date -->
                            <div class="form-group">
                                <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.birth_date') }}</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                            </div>
                            <!-- Active Checkbox -->
                            <div class="form-group flex items-center mt-2">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400">
                                <span class="ml-2 text-xs text-slate-600">{{ __('lms.common.active_user') }}</span>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.address') }}</label>
                            <textarea name="address" rows="1" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Biography -->
                        <div class="form-group mt-3">
                            <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.biography') }}</label>
                            <textarea name="bio" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('admin.users.index')">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.common.update_user') }}</x-ds.button>
                        </x-lms-form-actions>
                    </x-lms-form-card>
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
