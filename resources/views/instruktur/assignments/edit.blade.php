<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Assignment</h1>
                <p class="text-sm text-slate-500 mt-0.5">Update assignment information for <span class="font-semibold">{{ $class->title }}</span></p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Stream
                </a>
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
        <div class="dashboard-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
            <form action="{{ route('instruktur.assignments.update', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Assignment Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required
                              class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $assignment->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Attachment (File) --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attachment (Optional)</label>
                    <div class="relative border-2 border-dashed border-slate-300 rounded-lg hover:border-blue-400 transition cursor-pointer bg-slate-50/50">
                        <input type="file" name="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center py-6 px-4">
                            <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500">Click or drag to upload a new file</p>
                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, PPT, ZIP (Max 100MB)</p>
                        </div>
                    </div>
                    @if($assignment->attachment)
                        <p class="text-xs text-green-600 mt-2">✓ Current file: {{ basename($assignment->attachment) }}</p>
                    @endif
                    @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="deadline" value="{{ old('deadline', $assignment->deadline->format('Y-m-d\TH:i')) }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">Students cannot submit after the deadline</p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-3d px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Update Assignment
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
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>