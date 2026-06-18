<x-app-layout>
<div class="edit-material-wrapper lms-page-shell max-w-7xl mx-auto space-y-6">
        <x-lms-page-header
            :title="__('lms.material.edit')"
            :subtitle="__('lms.material.edit_subtitle', ['title' => $class->title])"
            :back-url="route('instruktur.materials.index', $class)"
            :back-label="__('lms.material.back_materials')"
        />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <x-lms-form-card :title="__('lms.material.edit_form')">
            <form action="{{ route('instruktur.materials.update', [$class, $material]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                @include('instruktur.materials.form')

                <x-lms-form-actions>
                    <x-ds.button tag="a" variant="secondary" :href="route('instruktur.materials.index', $class)">{{ __('lms.cancel') }}</x-ds.button>
                    <x-ds.button type="submit" variant="primary">{{ __('lms.material.update_btn') }}</x-ds.button>
                </x-lms-form-actions>
            </form>
        </x-lms-form-card>
    </div>
</x-app-layout>
