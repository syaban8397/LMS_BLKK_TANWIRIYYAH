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
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf

                @include('admin.classes.form')

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.classes.index') }}"
                       class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        {{ __('lms.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm hover:shadow-md">
                        {{ __('lms.common.save_class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
