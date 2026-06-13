<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(30px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        /* Animasi untuk card form */
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        /* Animasi untuk setiap group input */
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .edit-assignment-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Card form 3D */
        .form-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }
        .form-card:hover {
            transform: translateY(-5px) rotateX(2deg) rotateY(1deg);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        /* Setiap group input */
        .form-group {
            animation: fadeSlideUp 0.4s ease forwards;
            opacity: 0;
        }
        /* Stagger delay untuk setiap field */
        .form-group:nth-child(1) { animation-delay: 0.05s; }  /* Title */
        .form-group:nth-child(2) { animation-delay: 0.1s; }  /* Description */
        .form-group:nth-child(3) { animation-delay: 0.15s; } /* Attachment */
        .form-group:nth-child(4) { animation-delay: 0.2s; }  /* Deadline */
        .form-group:nth-child(5) { animation-delay: 0.25s; } /* Late Submission Option */

        /* Input field 3D */
        .input-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .input-3d:focus {
            transform: scale(1.01) translateZ(3px);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            border-color: #3b82f6;
            outline: none;
        }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
            display: inline-flex;
            align-items: center;
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Upload area 3D */
        .upload-area {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .upload-area:hover {
            transform: translateY(-2px);
            border-color: #3b82f6;
            background-color: #f8fafc;
        }

        /* Checkbox styling */
        .checkbox-label {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .checkbox-label:hover {
            transform: translateY(-2px);
        }
        input[type="checkbox"] {
            transition: all 0.2s ease;
        }
        input[type="checkbox"]:hover {
            transform: scale(1.05);
        }

        /* Warning box untuk deadline yang sudah lewat */
        .warning-box {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .warning-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="edit-assignment-wrapper space-y-6">
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
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Warning jika deadline sudah lewat --}}
        @if($assignment->deadline->isPast())
            <div class="warning-box bg-amber-50 border-l-4 border-amber-500 text-amber-700 rounded-lg p-3 text-sm shadow-sm">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="font-semibold">Deadline has passed</p>
                        <p class="text-xs text-amber-600 mt-0.5">
                            Current deadline: {{ $assignment->deadline->format('d M Y H:i') }}. 
                            @if($assignment->late_submission_allowed)
                                Late submissions are currently <span class="font-bold">ALLOWED</span>.
                            @else
                                Late submissions are currently <span class="font-bold">NOT ALLOWED</span>.
                            @endif
                            You can change the setting below.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="form-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
            <form action="{{ route('instruktur.assignments.update', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Assignment Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required
                              class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">{{ old('description', $assignment->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Attachment (File) --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attachment (Optional)</label>
                    <div class="upload-area relative border-2 border-dashed border-slate-300 rounded-lg hover:border-blue-400 transition cursor-pointer bg-slate-50/50">
                        <input type="file" name="attachment" id="attachment_input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center py-6 px-4">
                            <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500">Click or drag to upload a new file</p>
                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, PPT, ZIP, JPG, PNG (Max 100MB)</p>
                            <div id="file_name_display" class="mt-2 text-xs text-blue-600 font-medium hidden"></div>
                        </div>
                    </div>
                    @if($assignment->attachment)
                        <p class="text-xs text-green-600 mt-2">✓ Current file: {{ basename($assignment->attachment) }}</p>
                    @endif
                    @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="deadline" value="{{ old('deadline', $assignment->deadline->format('Y-m-d\TH:i')) }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">Perpanjang deadline dengan mengubah tanggal/waktu di atas</p>
                </div>

                {{-- Late Submission Option --}}
                <div class="form-group">
                    <input type="hidden" name="late_submission_allowed" value="0">
                    <label class="checkbox-label flex items-start gap-3 cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 transition-all">
                        <input type="checkbox" name="late_submission_allowed" value="1" {{ $assignment->late_submission_allowed ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mt-0.5">
                        <div class="flex-1">
                            <span class="text-sm font-semibold text-slate-700 block">Allow late submissions</span>
                            <p class="text-xs text-slate-500 mt-1">
                                ✅ If checked: Students can still submit after the deadline. Submissions will be marked as <span class="text-amber-600 font-medium">"Late"</span>.
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                ❌ If unchecked: Students cannot submit after the deadline. Submission form will be completely closed.
                            </p>
                            @if($assignment->deadline->isPast())
                                <p class="text-xs text-amber-600 mt-2 font-medium">
                                    ⚠️ Deadline has passed. Changing this setting will affect whether students can still submit.
                                </p>
                            @endif
                        </div>
                    </label>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Information</p>
                            <p class="text-xs text-blue-700 mt-1">
                                Students who have already submitted will not be affected by this change. This setting only applies to future submissions.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Delete Assignment Button (Opsional) --}}
                <div class="border-t border-slate-200 pt-4">
                    <form action="{{ route('instruktur.assignments.destroy', [$class, $assignment]) }}" method="POST" 
                          onsubmit="return confirm('Delete this assignment? This action cannot be undone. All student submissions will also be deleted.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-3d px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            🗑️ Delete Assignment
                        </button>
                    </form>
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

    <script>
        document.getElementById('attachment_input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const displayDiv = document.getElementById('file_name_display');
            if (file) {
                displayDiv.textContent = 'Selected: ' + file.name;
                displayDiv.classList.remove('hidden');
            } else {
                displayDiv.textContent = '';
                displayDiv.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>