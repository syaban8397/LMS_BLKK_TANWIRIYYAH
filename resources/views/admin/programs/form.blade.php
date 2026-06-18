<x-app-layout>
<div class="create-program-wrapper space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ __('lms.common.create_program') }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ __('lms.common.create_program_subtitle') }}</p>
            </div>
            <div class="badge-3d hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-sm">
                📚 {{ __('lms.common.program_management') }}
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <form action="{{ route('admin.programs.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div class="form-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">
                            {{ __('lms.common.program_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="{{ __('lms.common.program_name') }}"
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">
                            {{ __('lms.common.description') }}
                        </label>
                        <textarea name="description" rows="3"
                                  placeholder="{{ __('lms.common.description') }}"
                                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">
                                {{ __('lms.common.start_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2" required>
                            @error('start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-xs font-medium text-slate-500 mb-1">
                                {{ __('lms.common.end_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2" required>
                            @error('end_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @include('admin.programs._certificate-fields', ['program' => new \App\Models\Program()])

                    @include('admin.programs._capacity-field', ['program' => new \App\Models\Program()])
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.programs.index') }}"
                       class="lms-btn-secondary">
                        {{ __('lms.cancel') }}
                    </a>
                    <button type="submit"
                            class="lms-btn-primary hover:shadow-md">
                        {{ __('lms.common.save_program') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
