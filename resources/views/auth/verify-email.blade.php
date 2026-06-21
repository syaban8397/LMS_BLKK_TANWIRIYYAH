<x-guest-layout>
    <x-lms-auth-shell
        :title="__('lms.auth.verify_account')"
        :subtitle="__('lms.auth.verify_email_message')"
    >
        @if (session('status') == 'verification-link-sent')
            <x-lms-flash type="success" class="mb-5">{{ __('lms.auth.verification_link_sent') }}</x-lms-flash>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-auth-primary sm:w-auto">
                    {{ __('lms.auth.resend_verification') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="lms-auth-link text-sm font-medium">
                    {{ __('lms.auth.log_out') }}
                </button>
            </form>
        </div>
    </x-lms-auth-shell>
</x-guest-layout>
