<x-app-layout>
    <x-slot:title>{{ __('lms.common.edit_class') }}</x-slot:title>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="__('lms.common.edit_class')"
            :subtitle="__('lms.common.edit_class_subtitle', ['title' => $class->title])"
            :back-url="route('admin.classes.show', $class)"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--warning">{{ __('lms.common.edit_mode') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card>
            <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.classes.form')

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('admin.classes.index')">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.common.update_class') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
