<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div><h2 class="text-2xl font-bold text-slate-800">Meeting {{ $meetingNumber }} - Attendance</h2><p class="text-sm text-slate-500 mt-1">{{ $class->title }} • {{ Carbon\Carbon::parse($meetingDate)->format('d F Y') }}</p></div>
            <div class="flex gap-2"><a href="{{ route('instruktur.attendances.edit', [$class, $meetingNumber]) }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl transition">✏️ Edit</a><a href="{{ route('instruktur.attendances.index', $class) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl transition">Back</a></div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        <div class="grid md:grid-cols-4 gap-4">
            <div class="bg-green-50 rounded-2xl p-4 text-center"><p class="text-3xl font-bold text-green-700">{{ $summary['present'] }}</p><p class="text-sm text-green-600">Present</p></div>
            <div class="bg-yellow-50 rounded-2xl p-4 text-center"><p class="text-3xl font-bold text-yellow-700">{{ $summary['permission'] }}</p><p class="text-sm text-yellow-600">Permission</p></div>
            <div class="bg-orange-50 rounded-2xl p-4 text-center"><p class="text-3xl font-bold text-orange-700">{{ $summary['sick'] }}</p><p class="text-sm text-orange-600">Sick</p></div>
            <div class="bg-red-50 rounded-2xl p-4 text-center"><p class="text-3xl font-bold text-red-700">{{ $summary['absent'] }}</p><p class="text-sm text-red-600">Absent</p></div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200"><h3 class="font-bold text-slate-800">Student Details</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm"><tr><th class="px-6 py-4 text-left">Student</th><th class="px-6 py-4 text-left">Status</th><th class="px-6 py-4 text-left">Submission Type</th><th class="px-6 py-4 text-left">Check In Time</th><th class="px-6 py-4 text-left">Notes</th></tr></thead>
                    <tbody>@foreach($attendances as $attendance)<tr class="border-t hover:bg-slate-50"><td class="px-6 py-4"><p class="font-medium text-slate-800">{{ $attendance->participant->name }}</p><p class="text-xs text-slate-500">{{ $attendance->participant->email }}</p></td><td class="px-6 py-4">@php $statusLabels = ['present'=>'Present','permission'=>'Permission','sick'=>'Sick','absent'=>'Absent']; $statusColors = ['present'=>'bg-green-100 text-green-700','permission'=>'bg-yellow-100 text-yellow-700','sick'=>'bg-orange-100 text-orange-700','absent'=>'bg-red-100 text-red-700']; @endphp<span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$attendance->status] }}">{{ $statusLabels[$attendance->status] }}</span></td><td class="px-6 py-4">@if($attendance->submission_type == 'self')<span class="text-xs text-blue-600">📱 Self</span>@else<span class="text-xs text-amber-600">✏️ By Instructor</span>@endif</td><td class="px-6 py-4 text-slate-600">{{ $attendance->check_in_time ?? '-' }}</td><td class="px-6 py-4 text-slate-600">{{ $attendance->notes ?? '-' }}</td></tr>@endforeach</tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>