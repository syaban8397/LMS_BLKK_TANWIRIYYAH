<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-purple-900 to-pink-900 -mx-6 -mt-6 px-6 py-12 rounded-b-3xl shadow-2xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-full px-3 py-1 text-xs text-white mb-3">
                        <span class="animate-pulse">●</span> Dashboard
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">My Classes</h1>
                    <p class="text-indigo-100 mt-2 text-sm md:text-base">Manage and monitor all classes you are teaching</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-2 border border-white/20">
                        <span class="text-white/80 text-sm">Instructor</span>
                        <p class="text-white font-bold">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-8">
        @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 text-emerald-800 p-5 rounded-2xl shadow-md flex items-center gap-3 backdrop-blur-sm">
                <div class="p-2 bg-emerald-100 rounded-full"><svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards - Luxury -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-indigo-500 text-sm font-semibold uppercase tracking-wider">Total Classes</p>
                        <h3 class="text-5xl font-black text-gray-800 mt-2">{{ $totalClasses }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform rotate-6 group-hover:rotate-12 transition">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-semibold uppercase tracking-wider">Active Classes</p>
                        <h3 class="text-5xl font-black text-gray-800 mt-2">{{ $activeClasses }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg transform -rotate-6 group-hover:rotate-12 transition">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-pink-400/20 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-purple-500 text-sm font-semibold uppercase tracking-wider">Total Students</p>
                        <h3 class="text-5xl font-black text-gray-800 mt-2">{{ $totalStudents }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Table / Card View (Premium) -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100 flex justify-between items-center flex-wrap gap-3">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Class List
                </h3>
                <div class="text-sm text-gray-500">Showing {{ $classes->firstItem() ?? 0 }} - {{ $classes->lastItem() ?? 0 }} of {{ $classes->total() }}</div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-600 text-sm border-b">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Class</th>
                            <th class="px-6 py-4 text-left font-semibold">Program</th>
                            <th class="px-6 py-4 text-center font-semibold">Period</th>
                            <th class="px-6 py-4 text-center font-semibold">Students</th>
                            <th class="px-6 py-4 text-center font-semibold">Status</th>
                            <th class="px-6 py-4 text-center font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($classes as $class)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-transparent transition group">
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-800">{{ $class->title }}</div>
                                <div class="text-sm text-gray-400 font-mono">{{ $class->code }}</div>
                            </td>
                            <td class="px-6 py-5 text-gray-600">{{ $class->program->name }}</td>
                            <td class="px-6 py-5 text-center text-gray-600 text-sm">
                                {{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <span class="font-bold text-gray-800">{{ $class->participants->count() }}</span>
                                    <span class="text-gray-400">/</span>
                                    <span class="text-gray-500">{{ $class->quota }}</span>
                                    <div class="w-12 h-1.5 bg-gray-200 rounded-full ml-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($class->participants->count() / max($class->quota,1)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusBadge = [
                                        'draft' => ['bg-gray-100 text-gray-700', 'Draft'],
                                        'active' => ['bg-emerald-100 text-emerald-700', 'Active'],
                                        'completed' => ['bg-blue-100 text-blue-700', 'Completed'],
                                        'cancelled' => ['bg-red-100 text-red-700', 'Cancelled']
                                    ];
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusBadge[$class->status][0] }}">{{ $statusBadge[$class->status][1] }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('instruktur.classes.stream', $class) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white rounded-xl text-sm font-semibold shadow-md transition transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-4H7v4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6"></path></svg>
                                    <p class="text-lg">No classes assigned yet.</p>
                                    <p class="text-sm">You haven't been assigned to any classes.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                {{ $classes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>