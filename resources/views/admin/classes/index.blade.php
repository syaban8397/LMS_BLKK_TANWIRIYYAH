<x-app-layout>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Classes</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage all classes available in the LMS.</p>
            </div>
            <a href="{{ route('admin.classes.create') }}" 
               class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                + New Class
            </a>
        </div>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Classes</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalClasses }}</p>
                    </div>
                    <div class="text-xl">📚</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Active Classes</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeClasses }}</p>
                    </div>
                    <div class="text-xl">✅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Draft Classes</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $draftClasses }}</p>
                    </div>
                    <div class="text-xl">📝</div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">Class</th>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-left">Instructor</th>
                            <th class="px-4 py-3 text-center">Period</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classes as $class)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $class->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $class->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->program->name }}</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">{{ $class->instructor->name }}</td>
                                <td class="px-4 py-3 text-center text-slate-600 text-xs">
                                    {{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @switch($class->status)
                                        @case('draft')
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Draft</span>
                                            @break
                                        @case('active')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                                            @break
                                        @case('completed')
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Completed</span>
                                            @break
                                        @case('cancelled')
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.classes.show', $class) }}" class="btn-action px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition">View</a>
                                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn-action px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs transition">Edit</a>
                                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-sm">No classes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 text-xs">
                {{ $classes->links() }}
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-action {
            transition: all 0.2s ease;
        }
        .btn-action:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>