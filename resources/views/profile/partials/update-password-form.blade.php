<div class="lms-form-layout">
    <x-lms-form-card :description="__('lms.profile_page.update_password_desc_long')">
        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('lms.profile_page.current_password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('lms.profile_page.new_password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('lms.auth.confirm_password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <x-lms-form-actions>
                <button type="submit" class="lms-btn-primary">{{ __('lms.save') }}</button>
                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 dark:text-green-400"
                    >{{ __('lms.profile_page.saved') }}</p>
                @endif
            </x-lms-form-actions>
        </form>
    </x-lms-form-card>
</div>
