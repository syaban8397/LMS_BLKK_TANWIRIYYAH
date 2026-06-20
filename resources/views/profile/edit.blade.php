<x-app-layout>
    <div class="lms-page-shell max-w-5xl mx-auto space-y-6">
        <x-lms-page-header :title="__('lms.profile')" :subtitle="__('lms.profile_page.subtitle')" />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid lg:grid-cols-3 gap-5">
                <div class="card-3d">
                    <x-lms-form-card :title="__('lms.common.profile_photo')" icon="camera">
                        <div class="flex flex-col items-center text-center">
                            <img id="photo-preview"
                                 src="{{ $user->profilePhotoUrl() }}"
                                 alt="{{ $user->name }}"
                                 class="w-32 h-32 rounded-2xl object-cover border border-slate-200 dark:border-slate-600 shadow-md ring-4 ring-brand-50 dark:ring-brand-900/30">
                            <p class="mt-3 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ __('lms.roles.' . $user->role) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $user->email }}</p>

                            <label for="photo" class="mt-4 w-full cursor-pointer">
                                <span class="lms-btn-secondary w-full inline-flex justify-center text-xs py-2">
                                    {{ __('lms.profile_page.upload_new_photo') }}
                                </span>
                                <input id="photo" name="photo" type="file" accept="image/*" class="sr-only" onchange="previewPhoto(event)">
                            </label>
                            <p class="text-[11px] text-slate-400 mt-2">{{ __('lms.common.leave_blank') }}</p>
                            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                        </div>
                    </x-lms-form-card>
                </div>

                <div class="lg:col-span-2 card-3d">
                    <x-lms-form-card :title="__('lms.common.user_information')" icon="edit">
                        <p class="text-xs text-slate-500 mb-4">{{ __('lms.profile_page.subtitle') }}</p>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('lms.auth.full_name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('lms.auth.email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="nik" :value="__('lms.auth.nik')" />
                                <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik', $user->nik)" />
                                <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('lms.auth.phone')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('lms.auth.gender')" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-slate-300 dark:border-slate-600 dark:bg-slate-800 rounded-lg">
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <div>
                                <x-input-label for="birth_place" :value="__('lms.auth.birth_place')" />
                                <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place', $user->birth_place)" />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('lms.auth.birth_date')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user->birth_date?->format('Y-m-d'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('lms.auth.address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="bio" :value="__('lms.report.bio')" />
                            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-slate-300 dark:border-slate-600 dark:bg-slate-800 rounded-lg">{{ old('bio', $user->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>

                        <x-lms-form-actions>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.save') }}</x-ds.button>
                        </x-lms-form-actions>
                    </x-lms-form-card>
                </div>
            </div>
        </form>

        <div class="premium-card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="premium-card p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
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
