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
        /* Animasi untuk baris siswa */
        @keyframes rowFadeIn {
            0% { opacity: 0; transform: translateX(-8px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .edit-attendance-wrapper {
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
        .form-group:nth-child(1) { animation-delay: 0.05s; }  /* Attendance Date */
        .form-group:nth-child(2) { animation-delay: 0.1s; }  /* Deadline Info */
        .form-group:nth-child(3) { animation-delay: 0.15s; } /* Student List Title */

        /* Student list container dan baris */
        .student-list-container {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.2s;
        }
        .student-row {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .student-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }
        /* Stagger delay untuk baris siswa (maksimal 20) */
        .student-row:nth-child(1) { animation-delay: 0.25s; }
        .student-row:nth-child(2) { animation-delay: 0.3s; }
        .student-row:nth-child(3) { animation-delay: 0.35s; }
        .student-row:nth-child(4) { animation-delay: 0.4s; }
        .student-row:nth-child(5) { animation-delay: 0.45s; }
        .student-row:nth-child(6) { animation-delay: 0.5s; }
        .student-row:nth-child(7) { animation-delay: 0.55s; }
        .student-row:nth-child(8) { animation-delay: 0.6s; }
        .student-row:nth-child(9) { animation-delay: 0.65s; }
        .student-row:nth-child(10) { animation-delay: 0.7s; }
        .student-row:nth-child(11) { animation-delay: 0.75s; }
        .student-row:nth-child(12) { animation-delay: 0.8s; }
        .student-row:nth-child(13) { animation-delay: 0.85s; }
        .student-row:nth-child(14) { animation-delay: 0.9s; }
        .student-row:nth-child(15) { animation-delay: 0.95s; }
        .student-row:nth-child(16) { animation-delay: 1s; }
        .student-row:nth-child(17) { animation-delay: 1.05s; }
        .student-row:nth-child(18) { animation-delay: 1.1s; }
        .student-row:nth-child(19) { animation-delay: 1.15s; }
        .student-row:nth-child(20) { animation-delay: 1.2s; }

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

        /* Select 3D */
        .status-select {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .status-select:focus {
            transform: scale(1.01);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
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

        /* Deadline info box */
        .deadline-box {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }
        .deadline-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="edit-attendance-wrapper space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Attendance Session</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} - Meeting {{ $meetingNumber }}</p>
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
            <form action="{{ route('instruktur.attendances.update', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Attendance Date --}}
                <div class="form-group">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Attendance Date & Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="attendance_date" value="{{ old('attendance_date', $meetingDate ? $meetingDate->format('Y-m-d\TH:i') : '') }}" required
                           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2">
                    @error('attendance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Deadline Info & Extension --}}
                <div class="form-group">
                    <div class="deadline-box bg-gray-50 rounded-lg p-4 border border-gray-200 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Batas Waktu Absensi Saat Ini</label>
                            <input type="text" value="{{ $deadline ? $deadline->format('d/m/Y H:i') : 'Belum diatur' }}" readonly
                                   class="w-full rounded-lg bg-gray-100 border-gray-200 text-sm px-3 py-2 text-slate-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Perpanjang Deadline (menit)</label>
                            <input type="number" name="extend_deadline_minutes" value="{{ old('extend_deadline_minutes', 0) }}" min="0" max="1440"
                                   class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2"
                                   placeholder="0 = tidak diperpanjang">
                            <p class="text-xs text-slate-400 mt-1">Isi jumlah menit tambahan jika ingin memperpanjang waktu absensi peserta.</p>
                            @error('extend_deadline_minutes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Students Attendance List --}}
                <div class="form-group">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Student Attendance Status</label>
                </div>
                <div class="student-list-container">
                    <div class="space-y-3 max-h-96 overflow-y-auto border border-slate-200 rounded-xl p-4 bg-slate-50/30">
                        @foreach($students as $student)
                            @php
                                $attendanceRecord = $attendances[$student->participant_id] ?? null;
                                $currentStatus = $attendanceRecord ? $attendanceRecord->status : 'absent';
                                $currentNotes = $attendanceRecord ? $attendanceRecord->notes : '';
                            @endphp
                            <div class="student-row flex flex-wrap items-center gap-4 p-3 bg-white rounded-lg border border-slate-100">
                                <div class="w-64">
                                    <p class="font-medium text-slate-800">{{ $student->participant->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $student->participant->email }}</p>
                                </div>
                                <div class="flex-1 min-w-[200px]">
                                    <select name="attendances[{{ $loop->index }}][status]" class="status-select rounded-lg border-slate-300 text-sm px-3 py-2 w-full focus:ring-blue-400">
                                        <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }}>✅ Present</option>
                                        <option value="permission" {{ $currentStatus == 'permission' ? 'selected' : '' }}>📝 Permission</option>
                                        <option value="sick" {{ $currentStatus == 'sick' ? 'selected' : '' }}>🤒 Sick</option>
                                        <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                                    </select>
                                    <input type="hidden" name="attendances[{{ $loop->index }}][participant_id]" value="{{ $student->participant_id }}">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="attendances[{{ $loop->index }}][notes]" value="{{ old('attendances.'.$loop->index.'.notes', $currentNotes) }}"
                                           placeholder="Notes (optional)" class="w-full rounded-lg border-slate-300 text-sm px-3 py-2 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('attendances')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('instruktur.attendances.index', [$class, $meetingNumber]) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        Update Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>