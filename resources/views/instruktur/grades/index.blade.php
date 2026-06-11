<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div><h2 class="text-2xl font-bold">{{ $assignment->title }} - Submissions</h2><p>{{ $class->title }}</p></div>
            <a href="{{ route('instruktur.classes.stream', $class) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back</a>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl shadow"><p class="text-slate-500">Total</p><p class="text-2xl font-bold">{{ $stats['total'] }}</p></div>
            <div class="bg-green-50 p-4 rounded-2xl"><p class="text-green-600">Submitted</p><p class="text-2xl font-bold">{{ $stats['submitted'] }}</p></div>
            <div class="bg-yellow-50 p-4 rounded-2xl"><p class="text-yellow-600">Late</p><p class="text-2xl font-bold">{{ $stats['late'] }}</p></div>
            <div class="bg-blue-50 p-4 rounded-2xl"><p class="text-blue-600">Graded</p><p class="text-2xl font-bold">{{ $stats['graded'] }}</p></div>
        </div>
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Student</th>
                        <th class="px-6 py-3 text-left">Submitted At</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Score</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $s->participant->name }}</td>
                        <td class="px-6 py-4">{{ $s->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($s->status=='graded') <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Graded</span>
                            @elseif($s->status=='late') <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Late</span>
                            @else <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Submitted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">{{ $s->score ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('instruktur.grades.show', [$class, $assignment, $s]) }}" class="px-3 py-1 bg-sky-500 text-white rounded-lg text-sm">Grade</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No submissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $submissions->links() }}</div>
        </div>
    </div>
</x-app-layout>