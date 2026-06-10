    <x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div><h2 class="text-2xl font-bold text-slate-800">Attendance Report</h2><p class="text-sm text-slate-500 mt-1">{{ $class->title }}</p></div>
            <div class="flex gap-2"><a href="{{ route('instruktur.attendances.index', $class) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl transition">Back</a></div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50"><h3 class="font-bold text-slate-800">Student Attendance Matrix</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr><th class="px-4 py-3 text-left">Student</th>@foreach($meetings as $meeting)<th class="px-3 py-3 text-center">M{{ $meeting->meeting_number }}<br><span class="text-xs">{{ $meeting->attendance_date->format('d/m') }}</span></th>@endforeach<th class="px-3 py-3 text-center">✅</th><th class="px-3 py-3 text-center">📝</th><th class="px-3 py-3 text-center">🤒</th><th class="px-3 py-3 text-center">❌</th></tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceMatrix as $studentId => $data)
                        <tr class="border-t hover:bg-slate-50">
                            <td class="px-4 py-3"><p class="font-medium text-slate-800">{{ $data['name'] }}</p></td>
                            @foreach($meetings as $meeting)
                            <td class="px-3 py-3 text-center">@php $status = $data['attendances'][$meeting->meeting_number] ?? '-'; $colors = ['present'=>'bg-green-100 text-green-700','permission'=>'bg-yellow-100 text-yellow-700','sick'=>'bg-orange-100 text-orange-700','absent'=>'bg-red-100 text-red-700','-'=>'bg-slate-100 text-slate-400']; $icons = ['present'=>'✓','permission'=>'📝','sick'=>'🤒','absent'=>'✗','-'=>'−']; @endphp<span class="inline-block w-8 h-8 leading-8 rounded-full text-xs font-semibold {{ $colors[$status] }}">{{ $icons[$status] }}</span></td>
                            @endforeach
                            <td class="px-3 py-3 text-center font-bold text-green-700">{{ $data['present_count'] }}</td>
                            <td class="px-3 py-3 text-center font-bold text-yellow-700">{{ $data['permission_count'] }}</td>
                            <td class="px-3 py-3 text-center font-bold text-orange-700">{{ $data['sick_count'] }}</td>
                            <td class="px-3 py-3 text-center font-bold text-red-700">{{ $data['absent_count'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>