<x-app-layout>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create Training Program</h1>
                <p class="text-sm text-slate-500 mt-0.5">Add a new training program to the LMS BLKK Tanwiriyyah system.</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-sm">
                📚 Program Management
            </div>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="dashboard-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <form action="{{ route('admin.programs.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-2 gap-5">
                    {{-- Program Name --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Program Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Description</label>
                        <textarea name="description" rows="3" 
                                  class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">{{ old('description') }}</textarea>
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm" required>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Capacity (opsional) --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Capacity (optional)</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" 
                               class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.programs.index') }}" 
                       class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm hover:shadow-md">
                        Save Program
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .input-3d {
            transition: all 0.2s ease;
        }
        .input-3d:focus {
            transform: scale(1.01);
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
            border-color: #3b82f6;
        }
    </style>
</x-app-layout>