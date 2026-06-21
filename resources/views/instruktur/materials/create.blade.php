<x-app-layout>
    <x-lms-page-shell class="create-material-wrapper max-w-7xl mx-auto">
<x-lms-page-header
            :title="__('lms.material.create')"
            :subtitle="__('lms.material.create_subtitle', ['title' => $class->title])"
            :back-url="route('instruktur.materials.index', $class)"
            :back-label="__('lms.material.back_materials')"
        />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-section compact>
            <div class="lms-form-layout lms-form-layout--wide\">
        <x-lms-form-card :title="__('lms.material.info_title')">
            <p class="text-xs text-slate-500 mb-4">{{ __('lms.material.form_hint') }}</p>
            <form action="{{ route('instruktur.materials.store', $class) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @include('instruktur.materials.form')

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('instruktur.materials.index', $class)">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.material.create_btn') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
            </div>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
