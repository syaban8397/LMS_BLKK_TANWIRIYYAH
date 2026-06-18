<x-app-layout>
    <x-slot:title>{{ __('lms.common.create_new_class') }}</x-slot:title>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.common.create_new_class')"
            :subtitle="__('lms.common.create_class_subtitle')"
            :back-url="route('admin.classes.index')"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--info">{{ __('lms.common.class_management') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card>
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf

                @include('admin.classes.form')

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('admin.classes.index')">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.common.save_class') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
