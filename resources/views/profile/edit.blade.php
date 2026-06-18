<x-app-layout>
    <div class="lms-page-shell max-w-4xl mx-auto space-y-6">
        <x-lms-page-header :title="__('lms.profile')" :subtitle="__('lms.profile_page.subtitle')" />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="premium-card p-6 sm:p-8 space-y-6">
            <div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('lms.profile') }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ __('lms.profile_page.subtitle') }}</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik', $user->nik)" />
                    <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select id="gender" name="gender" class="mt-1 block w-full border-slate-300 rounded-lg">
                        <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                        <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <div>
                    <x-input-label for="birth_place" :value="__('Birth Place')" />
                    <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place', $user->birth_place)" />
                    <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
                </div>

                <div>
                    <x-input-label for="birth_date" :value="__('Birth Date')" />
                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user->birth_date?->format('Y-m-d'))" />
                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                </div>

                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div>
                    <x-input-label for="bio" :value="__('Bio')" />
                    <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-slate-300 rounded-lg">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                </div>

                <div>
                    <x-input-label for="photo" :value="__('Photo')" />
                    <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm" accept="image/*" />
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="lms-btn-primary btn-3d">{{ __('lms.save') }}</button>
                </div>
            </form>
        </div>

        <div class="premium-card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="premium-card p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
