<x-app-layout>
<div class="edit-program-wrapper space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Training Program</h1>
                <p class="text-sm text-slate-500 mt-0.5">Update training program information in the LMS BLKK Tanwiriyyah system.</p>
            </div>
            <div class="badge-3d hidden md:flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs shadow-sm">
                ✏️ Edit Mode
            </div>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="form-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <form action="{{ route('admin.programs.update', $program) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-5">
                    {{-- Program Name (full width) --}}
                    <div class="md:col-span-2 input-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Program Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $program->name) }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    {{-- Description (full width) --}}
                    <div class="md:col-span-2 input-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Description</label>
                        <textarea name="description" rows="3" 
                                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">{{ old('description', $program->description) }}</textarea>
                    </div>

                    {{-- Start Date --}}
                    <div class="input-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', $program->start_date->format('Y-m-d')) }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    {{-- End Date --}}
                    <div class="input-group">
                        <label class="block text-xs font-medium text-slate-500 mb-1">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date', $program->end_date->format('Y-m-d')) }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    @include('admin.programs._certificate-fields', ['program' => $program])

                    @include('admin.programs._capacity-field', ['program' => $program])
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.programs.index') }}" 
                       class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="btn-3d px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm hover:shadow-md">
                        Update Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>