<x-app-layout>
    <x-slot:title>{{ __('lms.common.create_user') }}</x-slot:title>

    <x-lms-page-shell class="create-user-wrapper">
        <x-lms-page-header
            :title="__('lms.common.create_user')"
            :subtitle="__('lms.common.create_user_subtitle')"
            :back-url="route('admin.users.index')"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--info">{{ __('lms.nav.user_management') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-validation-errors />

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-lms-section :title="__('lms.common.create_user')" icon="users" compact>
                <div class="lms-form-layout lms-form-layout--wide">
                    <div class="grid lg:grid-cols-3 gap-5 lms-detail-grid">
                        <x-lms-form-card :title="__('lms.common.profile_photo')" icon="camera">
                            <div class="flex flex-col items-center">
                                <img id="photo-preview" src="https://ui-avatars.com/api/?name=User&size=120&background=3B82F6&color=fff"
                                     class="w-28 h-28 rounded-xl object-cover border shadow-sm">
                                <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)"
                                       class="mt-3 w-full rounded-lg border border-slate-200 p-1.5 text-xs focus:ring-1 focus:ring-blue-400">
                            </div>
                        </x-lms-form-card>

                        <div class="lg:col-span-2">
                            <x-lms-form-card :title="__('lms.common.user_information')" icon="edit">
                                <div class="grid md:grid-cols-2 gap-3">
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.role') }} *</label>
                                        <select name="role" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                            <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>{{ __('lms.roles.admin') }}</option>
                                            <option value="instruktur" {{ old('role')=='instruktur' ? 'selected' : '' }}>{{ __('lms.roles.instruktur') }}</option>
                                            <option value="peserta" {{ old('role')=='peserta' ? 'selected' : '' }}>{{ __('lms.roles.peserta') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.admin_page.approval_status') }}</label>
                                        <select name="approval_status" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                            <option value="approved" {{ old('approval_status')=='approved' ? 'selected' : '' }}>{{ __('lms.common.approved') }}</option>
                                            <option value="pending" {{ old('approval_status')=='pending' ? 'selected' : '' }}>{{ __('lms.common.pending') }}</option>
                                            <option value="rejected" {{ old('approval_status')=='rejected' ? 'selected' : '' }}>{{ __('lms.common.rejected') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.full_name') }} *</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.email') }} *</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.password') }} *</label>
                                        <input type="password" name="password" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.nik') }}</label>
                                        <input type="text" name="nik" value="{{ old('nik') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.phone_number') }}</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.gender') }}</label>
                                        <select name="gender" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                            <option value="">{{ __('lms.auth.select') }}</option>
                                            <option value="L" {{ old('gender')=='L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                                            <option value="P" {{ old('gender')=='P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.birth_place') }}</label>
                                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    </div>
                                    <div class="form-group">
                                        <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.birth_date') }}</label>
                                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">
                                    </div>
                                    <div class="form-group flex items-center mt-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400">
                                        <span class="ml-2 text-xs text-slate-600">{{ __('lms.common.active_user') }}</span>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.auth.address') }}</label>
                                    <textarea name="address" rows="1" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('address') }}</textarea>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="block text-xs font-medium text-slate-600 mb-0.5">{{ __('lms.common.biography') }}</label>
                                    <textarea name="bio" rows="2" class="input-3d w-full rounded-lg border-slate-200 text-xs py-2 px-2">{{ old('bio') }}</textarea>
                                </div>

                                <x-lms-form-actions>
                                    <x-ds.button tag="a" variant="secondary" :href="route('admin.users.index')">{{ __('lms.cancel') }}</x-ds.button>
                                    <x-ds.button type="submit" variant="primary">{{ __('lms.common.create_user_btn') }}</x-ds.button>
                                </x-lms-form-actions>
                            </x-lms-form-card>
                        </div>
                    </div>
                </div>
            </x-lms-section>
        </form>
    </x-lms-page-shell>

    <script>
        function previewPhoto(event) {
            const preview = document.getElementById('photo-preview');
            if (event.target.files && event.target.files[0]) {
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
