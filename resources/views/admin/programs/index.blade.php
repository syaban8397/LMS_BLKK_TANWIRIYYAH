<x-app-layout>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Training Programs</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage all training programs available in the LMS.</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" 
               class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                + New Program
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
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Programs</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalPrograms }}</p>
                    </div>
                    <div class="text-xl">📚</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Active Programs</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activePrograms }}</p>
                    </div>
                    <div class="text-xl">✅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Inactive Programs</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $inactivePrograms }}</p>
                    </div>
                    <div class="text-xl">⏸️</div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-center">Period</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Classes</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($programs as $program)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $program->name }}</div>
                                    <div class="text-xs text-slate-500">{{ Str::limit($program->description, 70) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 text-xs">
                                    {{ $program->start_date->format('d M Y') }} - {{ $program->end_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($program->status == 'active')
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-700 font-medium text-xs">
                                    {{ $program->classes()->count() }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.programs.show', $program) }}" class="btn-action px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition">View</a>
                                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-action px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs transition">Edit</a>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Delete this program?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-sm">No training programs available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 text-xs">
                {{ $programs->links() }}
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