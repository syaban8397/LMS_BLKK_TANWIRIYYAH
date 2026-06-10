{{-- resources/views/peserta/attendances/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Meeting {{ $meetingNumber }} - Submit Attendance</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $class->title }} • {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y') }}</p>
            </div>
            <a href="{{ route('peserta.attendances.index', $class) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">Back</a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-6">
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">{{ session('error') }}</div>
        @endif

        @if($attendance->submission_type == 'instructor')
            {{-- Locked by instructor --}}
            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center">
                <div class="text-6xl mb-4">🔒</div>
                <h3 class="text-xl font-bold text-amber-800 mb-2">Attendance Locked</h3>
                <p class="text-amber-700 mb-4">Your attendance has been modified by the instructor and cannot be changed.</p>
                <div class="bg-white rounded-2xl p-4 inline-block">
                    <p class="text-slate-600">Current Status: 
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
        @elseif(!$canSubmit)
            {{-- Deadline passed --}}
            <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center">
                <div class="text-6xl mb-4">⏰</div>
                <h3 class="text-xl font-bold text-red-800 mb-2">Submission Deadline Passed</h3>
                <p class="text-red-700">You can no longer submit attendance for this meeting. Please contact your instructor.</p>
            </div>
        @else
            {{-- Form submit/edit --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <form action="{{ route('peserta.attendances.submit', [$class, $meetingNumber]) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        {{-- Status Options --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-4">Choose Your Attendance Status</label>
                            <div class="grid md:grid-cols-3 gap-4">
                                <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="status" value="present" {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }} class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                    <div><span class="text-2xl">✅</span><p class="font-semibold text-green-700">Present</p><p class="text-xs text-slate-500">Attended the class</p></div>
                                </label>
                                <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition hover:bg-yellow-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                                    <input type="radio" name="status" value="permission" {{ old('status', $attendance->status) == 'permission' ? 'checked' : '' }} class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                                    <div><span class="text-2xl">📝</span><p class="font-semibold text-yellow-700">Permission</p><p class="text-xs text-slate-500">Had permission to be absent</p></div>
                                </label>
                                <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition hover:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="status" value="sick" {{ old('status', $attendance->status) == 'sick' ? 'checked' : '' }} class="w-5 h-5 text-orange-600 focus:ring-orange-500">
                                    <div><span class="text-2xl">🤒</span><p class="font-semibold text-orange-700">Sick</p><p class="text-xs text-slate-500">Was sick</p></div>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Add any additional information..." class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm px-4 py-3 text-slate-700">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                            <p class="text-sm text-blue-800 flex items-center gap-2">📌 <span>Your attendance will be recorded with your current check-in time. You can edit until the deadline (the day after meeting date).</span></p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-200 mt-8 pt-6 flex justify-end gap-3">
                        <a href="{{ route('peserta.attendances.index', $class) }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Cancel</a>
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                            {{ $attendance->status != 'absent' && $attendance->check_in_time ? 'Update Attendance' : 'Submit Attendance' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>