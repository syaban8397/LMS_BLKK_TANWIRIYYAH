<x-app-layout>
    <x-slot name="header"><div><h2 class="text-2xl font-bold text-slate-800">Create Attendance Session</h2><p class="text-sm text-slate-500 mt-1">{{ $class->title }}</p></div></x-slot>
    <div class="max-w-2xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
            <form action="{{ route('instruktur.attendances.store', $class) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Meeting Number</label><input type="number" name="meeting_number" value="{{ old('meeting_number', $nextMeeting) }}" min="1" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 px-4 py-3">@error('meeting_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Attendance Date</label><input type="date" name="attendance_date" value="{{ old('attendance_date', date('Y-m-d')) }}" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 px-4 py-3">@error('attendance_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4"><p class="text-sm text-yellow-800">⚠️ After creating this session, students can submit their attendance (present/permission/sick) until the day after the attendance date.</p></div>
                </div>
                <div class="border-t border-slate-200 mt-8 pt-6 flex justify-end gap-3"><a href="{{ route('instruktur.attendances.index', $class) }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 transition">Cancel</a><button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white transition">Create Session</button></div>
            </form>
        </div>
    </div>
</x-app-layout>