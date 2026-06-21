<x-app-layout>
    <x-slot:title>{{ __('lms.common.edit_class') }}</x-slot:title>

    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.common.edit_class')"
            :subtitle="__('lms.common.edit_class_subtitle', ['title' => $class->title])"
            :back-url="route('admin.classes.show', $class)"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--warning">{{ __('lms.common.edit_mode') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-validation-errors />

        <form action="{{ route('admin.classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')

            <x-lms-section :title="__('lms.common.edit_class')" icon="academic-cap" compact>
                <div class="lms-form-layout lms-form-layout--wide">
                    <x-lms-form-card :title="__('lms.common.class_information')" icon="edit">
                        @include('admin.classes.form')

                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('admin.classes.index')">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.common.update_class') }}</x-ds.button>
                        </x-lms-form-actions>
                    </x-lms-form-card>
                </div>
            </x-lms-section>
        </form>
    </x-lms-page-shell>
</x-app-layout>
