{{-- resources/views/peserta/attendances/show.blade.php --}}
<x-app-layout>
<div class="peserta-attendance-show-wrapper space-y-6">
        {{-- Header Sederhana dengan Tombol Back --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Meeting {{ $meetingNumber }} - Submit Attendance</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $class->title }} • {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Back to Attendance
                </a>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">{{ session('error') }}</div>
        @endif

        @php
            $isNotStarted = now()->lt($attendance->attendance_date);
        @endphp
        
        {{-- Card Utama --}}
        @if($attendance->submission_type == 'instructor')
            {{-- Locked by instructor --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>🔒</span> Attendance Locked
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="text-5xl mb-3">🔒</div>
                    <h4 class="text-lg font-bold text-amber-800 mb-2">Attendance Locked</h4>
                    <p class="text-amber-700 mb-4">Your attendance has been modified by the instructor and cannot be changed.</p>
                    <div class="bg-amber-50 rounded-xl p-4 inline-block border border-amber-200">
                        <p class="text-slate-700">Current Status: 
                            @php
                                $statusLabels = ['present' => '✅ Present', 'permission' => '📝 Permission', 'sick' => '🤒 Sick', 'absent' => '❌ Absent'];
                                $statusColors = ['present' => 'text-green-600', 'permission' => 'text-yellow-600', 'sick' => 'text-orange-600', 'absent' => 'text-red-600'];
                            @endphp
                            <span class="font-semibold {{ $statusColors[$attendance->status] }}">{{ $statusLabels[$attendance->status] }}</span>
                        </p>
                        @if($attendance->notes)
                            <p class="text-slate-500 text-sm mt-2">Notes: {{ $attendance->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif($isNotStarted)
        {{-- Sesi belum dimulai --}}
        <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span>⏳</span> Sesi Belum Dimulai
                </h3>
            </div>
            <div class="p-6 text-center">
                <div class="text-5xl mb-3">⏳</div>
                <h4 class="text-lg font-bold text-blue-800 mb-2">Belum Waktunya Absen</h4>
                <p class="text-blue-700">Sesi absensi akan dibuka pada <strong>{{ $attendance->attendance_date->format('d M Y H:i') }}</strong>.</p>
                <p class="text-blue-600 text-sm mt-2">Silakan kembali lagi pada waktu tersebut.</p>
            </div>
        </div>

        @elseif($isExpired)
            {{-- Deadline passed --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>⏰</span> Deadline Passed
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="text-5xl mb-3">⏰</div>
                    <h4 class="text-lg font-bold text-red-800 mb-2">Submission Deadline Passed</h4>
                    <p class="text-red-700">You can no longer submit attendance for this meeting. Please contact your instructor.</p>
                    @if($attendance->attendance_deadline)
                        <p class="text-sm text-red-600 mt-3">Deadline was: {{ $attendance->attendance_deadline->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>

        @else
            {{-- Form submit/edit --}}
            <div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span>📋</span> Attendance Form
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Select your status and add notes</p>
                </div>
                <div class="p-5">
                    <form action="{{ route('peserta.attendances.submit', [$class, $meetingNumber]) }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Status Options --}}
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Choose Your Attendance Status</label>
                            <div class="grid md:grid-cols-3 gap-4">
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="status" value="present" {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }} class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                    <div><span class="text-2xl">✅</span><p class="font-semibold text-green-700">Present</p><p class="text-xs text-slate-500">Attended the class</p></div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-yellow-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                                    <input type="radio" name="status" value="permission" {{ old('status', $attendance->status) == 'permission' ? 'checked' : '' }} class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                                    <div><span class="text-2xl">📝</span><p class="font-semibold text-yellow-700">Permission</p><p class="text-xs text-slate-500">Had permission to be absent</p></div>
                                </label>
                                <label class="radio-label flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="status" value="sick" {{ old('status', $attendance->status) == 'sick' ? 'checked' : '' }} class="w-5 h-5 text-orange-600 focus:ring-orange-500">
                                    <div><span class="text-2xl">🤒</span><p class="font-semibold text-orange-700">Sick</p><p class="text-xs text-slate-500">Was sick</p></div>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Add any additional information..." 
                                class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm px-3 py-2 transition-all">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="form-group bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-sm text-blue-800 flex items-center gap-2">
                                📌 <span>Your attendance will be recorded with your current check-in time. You can edit until the deadline ({{ $attendance->attendance_deadline ? $attendance->attendance_deadline->format('d M Y H:i') : 'not set' }}).</span>
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                            <a href="{{ route('peserta.attendances.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">Cancel</a>
                            <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                {{ $attendance->status != 'absent' && $attendance->check_in_time ? 'Update Attendance' : 'Submit Attendance' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>