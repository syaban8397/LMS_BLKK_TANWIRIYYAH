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

        .create-attendance-wrapper {
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
        .form-group:nth-child(1) { animation-delay: 0.05s; }  /* Meeting Number */
        .form-group:nth-child(2) { animation-delay: 0.1s; }  /* Attendance Date */
        .form-group:nth-child(3) { animation-delay: 0.15s; } /* Deadline Minutes */
        .form-group:nth-child(4) { animation-delay: 0.2s; }  /* Info Box (optional, tanpa animasi tapi ikut) */

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

        /* Info box 3D */
        .info-box {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            animation: fadeSlideUp 0.4s ease forwards 0.2s;
            opacity: 0;
        }
        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="create-attendance-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create Attendance Session</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('instruktur.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Sessions
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

        {{-- Form Card --}}
        <div class="form-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
            <form action="{{ route('instruktur.attendances.store', $class) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Meeting Number --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Meeting Number <span class="text-red-500">*</span></label>
                    <input type="number" name="meeting_number" value="{{ old('meeting_number', $nextMeeting) }}" min="1" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('meeting_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">Next available meeting: <span class="font-semibold text-blue-600">{{ $nextMeeting }}</span></p>
                </div>

                {{-- Attendance Date & Time (dengan jam) --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Class Start Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="attendance_date" 
                           value="{{ old('attendance_date', now()->format('Y-m-d\TH:i')) }}" 
                           required class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('attendance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline Minutes --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attendance Deadline (minutes after start) <span class="text-red-500">*</span></label>
                    <input type="number" name="deadline_minutes" value="{{ old('deadline_minutes', 60) }}" min="0" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('deadline_minutes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-slate-400 mt-1">
                        Students can submit attendance within <span class="font-semibold text-blue-600">{{ old('deadline_minutes', 60) }}</span> minutes after the class start time.
                        After that, the attendance session is closed for self-submission.
                    </p>
                </div>

                {{-- Info Note --}}
                <div class="info-box bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-semibold text-blue-800 text-sm">Information</p>
                            <p class="text-xs text-blue-600 mt-0.5">
                                After the deadline passes, students can no longer submit or change their attendance status.
                                Instructors can still edit attendance records manually if needed.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('instruktur.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Create Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>