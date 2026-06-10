<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div><h2 class="text-2xl font-bold text-slate-800">{{ $class->title }} - Attendance Sessions</h2><p class="text-sm text-slate-500 mt-1">Manage attendance sessions per meeting.</p></div>
            <div class="flex gap-2"><a href="{{ route('instruktur.attendances.create', $class) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-sm transition">+ New Session</a><a href="{{ route('instruktur.attendances.report', $class) }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl shadow-sm transition">📊 Report</a><a href="{{ route('instruktur.classes.stream', $class) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl shadow-sm transition">Back</a></div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))<div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">{{ session('error') }}</div>@endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-200"><h3 class="font-bold text-slate-800">Attendance Sessions</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm"><tr><th class="px-6 py-4 text-left">Meeting</th><th class="px-6 py-4 text-left">Date</th><th class="px-6 py-4 text-center">Present</th><th class="px-6 py-4 text-center">Permission</th><th class="px-6 py-4 text-center">Sick</th><th class="px-6 py-4 text-center">Absent</th><th class="px-6 py-4 text-center">Total</th><th class="px-6 py-4 text-center">Action</th></tr></thead>
                    <tbody>
                        @forelse($meetings as $meeting)
                        @php $stats = \App\Models\Attendance::where('class_id', $class->id)->where('meeting_number', $meeting->meeting_number)->get(); $present = $stats->where('status','present')->count(); $permission = $stats->where('status','permission')->count(); $sick = $stats->where('status','sick')->count(); $absent = $stats->where('status','absent')->count(); @endphp
                        <tr class="border-t hover:bg-slate-50 transition"><td class="px-6 py-4 font-medium text-slate-800">Meeting {{ $meeting->meeting_number }}</td><td class="px-6 py-4 text-slate-600">{{ Carbon\Carbon::parse($meeting->attendance_date)->format('d F Y') }}</td><td class="px-6 py-4 text-center text-green-600 font-semibold">{{ $present }}</td><td class="px-6 py-4 text-center text-yellow-600 font-semibold">{{ $permission }}</td><td class="px-6 py-4 text-center text-orange-600 font-semibold">{{ $sick }}</td><td class="px-6 py-4 text-center text-red-600 font-semibold">{{ $absent }}</td><td class="px-6 py-4 text-center text-slate-600">{{ $present+$permission+$sick+$absent }}</td><td class="px-6 py-4 text-center"><div class="flex gap-2 justify-center"><a href="{{ route('instruktur.attendances.show', [$class, $meeting->meeting_number]) }}" class="px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-sm">View</a><a href="{{ route('instruktur.attendances.edit', [$class, $meeting->meeting_number]) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm">Edit</a><form action="{{ route('instruktur.attendances.destroy', [$class, $meeting->meeting_number]) }}" method="POST" onsubmit="return confirm('Delete this session?')" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">Delete</button></form></div></td></tr>
                        @empty<tr><td colspan="8" class="px-6 py-8 text-center text-slate-500">No attendance sessions yet. <a href="{{ route('instruktur.attendances.create', $class) }}" class="text-blue-600 hover:underline">Create first session</a></td></tr>@endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>