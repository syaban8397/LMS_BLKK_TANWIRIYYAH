<div class="lms-form-layout">
    <x-lms-form-card :description="__('lms.profile_page.delete_account_desc')">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('lms.profile_page.delete_account') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('lms.profile_page.delete_confirm_title') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('lms.profile_page.delete_confirm_desc') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('lms.auth.password') }}" class="hidden" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('lms.auth.password') }}"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <x-lms-form-actions>
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('lms.cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('lms.profile_page.delete_account') }}
                    </x-danger-button>
                </x-lms-form-actions>
            </form>
        </x-modal>
    </x-lms-form-card>
</div>
