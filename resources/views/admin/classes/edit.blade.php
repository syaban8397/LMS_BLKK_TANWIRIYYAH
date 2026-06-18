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

        @if ($errors->any())
            <x-lms-flash type="error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-lms-flash>
        @endif

        <div class="dashboard-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.classes.form')

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.classes.index') }}"
                       class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        {{ __('lms.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm hover:shadow-md">
                        {{ __('lms.common.update_class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
