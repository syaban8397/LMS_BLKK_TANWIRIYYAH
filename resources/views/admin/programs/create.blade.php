<x-app-layout>
    <x-slot:title>{{ __('lms.common.create_program') }}</x-slot:title>

    <x-lms-page-shell class="create-program-wrapper">
        <x-lms-page-header
            :title="__('lms.common.create_program')"
            :subtitle="__('lms.common.create_program_subtitle')"
            :back-url="route('admin.programs.index')"
        >
            <x-slot:actions>
                <span class="lms-badge lms-badge--info">{{ __('lms.common.program_management') }}</span>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-validation-errors />

        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf

            <x-lms-section :title="__('lms.common.create_program')" icon="book" compact>
                <div class="lms-form-layout lms-form-layout--wide">
                    <x-lms-form-card>
                        <div class="grid md:grid-cols-2 gap-5">
                            {{-- Program Name (full width) --}}
                            <div class="md:col-span-2 input-group">
                                <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.program_name') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                            </div>

                            {{-- Description (full width) --}}
                            <div class="md:col-span-2 input-group">
                                <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.description') }}</label>
                                <textarea name="description" rows="3"
                                          class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">{{ old('description') }}</textarea>
                            </div>

                            {{-- Start Date --}}
                            <div class="input-group">
                                <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.start_date') }} <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}"
                                       class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                            </div>

                            {{-- End Date --}}
                            <div class="input-group">
                                <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('lms.common.end_date') }} <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}"
                                       class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                            </div>

                            {{-- Status, Gelar, Masa Berlaku --}}
                            @include('admin.programs._certificate-fields', ['program' => new \App\Models\Program()])

                            {{-- Kapasitas Kelas --}}
                            @include('admin.programs._capacity-field', ['program' => new \App\Models\Program()])
                        </div>

                        <x-lms-form-actions>
                            <x-ds.button tag="a" variant="secondary" :href="route('admin.programs.index')">{{ __('lms.cancel') }}</x-ds.button>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.common.save_program') }}</x-ds.button>
                        </x-lms-form-actions>
                    </x-lms-form-card>
                </div>
            </x-lms-section>
        </form>
    </x-lms-page-shell>
</x-app-layout>
