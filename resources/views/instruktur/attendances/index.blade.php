<x-app-layout>
    <div class="attendance-wrapper lms-page-shell space-y-6">
        <x-lms-page-header
            title="Attendance Sessions"
            :subtitle="$class->title . ' • Manage attendance per meeting'"
            :back-url="route('instruktur.classes.stream', $class)"
            back-label="← Back to Class"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.attendances.create', $class) }}" class="lms-btn-primary btn-3d">+ New Session</a>
                <a href="{{ route('instruktur.attendances.report', $class) }}" class="lms-btn-primary btn-3d !bg-green-600 hover:!bg-green-700">📊 Report</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <x-lms-card class="table-card p-0" title="Attendance Sessions" meta="Click View to see details, Edit to modify student status">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left">Meeting</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-center">✅ Present</th>
                            <th class="px-6 py-4 text-center">📝 Permission</th>
                            <th class="px-6 py-4 text-center">🤒 Sick</th>
                            <th class="px-6 py-4 text-center">❌ Absent</th>
                            <th class="px-6 py-4 text-center">Total</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meetings as $meeting)
                            @php
                                $stats = \App\Models\Attendance::where('class_id', $class->id)
                                    ->where('meeting_number', $meeting->meeting_number)
                                    ->get();
                                $present    = $stats->where('status','present')->count();
                                $permission = $stats->where('status','permission')->count();
                                $sick       = $stats->where('status','sick')->count();
                                $absent     = $stats->where('status','absent')->count();
                                $total      = $present + $permission + $sick + $absent;
                            @endphp
                            <tr class="attendance-row border-t border-slate-100 dark:border-slate-700/55 transition">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-100">Meeting {{ $meeting->meeting_number }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($meeting->attendance_date)->format('d F Y H:i') }}</td>
                                <td class="px-6 py-4 text-center text-green-600 dark:text-green-400 font-semibold">{{ $present }}</td>
                                <td class="px-6 py-4 text-center text-yellow-600 dark:text-yellow-400 font-semibold">{{ $permission }}</td>
                                <td class="px-6 py-4 text-center text-orange-600 dark:text-orange-400 font-semibold">{{ $sick }}</td>
                                <td class="px-6 py-4 text-center text-red-600 dark:text-red-400 font-semibold">{{ $absent }}</td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ $total }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('instruktur.attendances.show', [$class, $meeting->meeting_number]) }}" class="action-btn px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium">View</a>
                                        <a href="{{ route('instruktur.attendances.edit', [$class, $meeting->meeting_number]) }}" class="action-btn px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium">Edit</a>
                                        <form action="{{ route('instruktur.attendances.destroy', [$class, $meeting->meeting_number]) }}" method="POST" data-lms-confirm="Delete this entire attendance session? This action cannot be undone." class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                    <div class="text-4xl mb-2">📅</div>
                                    <p>No attendance sessions yet.</p>
                                    <a href="{{ route('instruktur.attendances.create', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">Create first session</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-lms-card>
    </div>
</x-app-layout>
