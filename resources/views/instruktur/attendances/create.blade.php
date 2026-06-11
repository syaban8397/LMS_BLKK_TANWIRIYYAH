<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-900 via-teal-900 to-cyan-900 -mx-6 -mt-6 px-6 py-12 rounded-b-3xl shadow-2xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-full px-3 py-1 text-xs text-white mb-3">
                        <span class="animate-pulse">●</span> Attendance Management
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">Create Attendance Session</h1>
                    <p class="text-emerald-100 mt-2 text-sm md:text-base">{{ $class->title }}</p>
                </div>
                <a href="{{ route('instruktur.attendances.index', $class) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white font-medium hover:bg-white/20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Sessions
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 px-6 py-5 border-b border-emerald-100">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    New Session Details
                </h3>
                <p class="text-gray-500 text-sm mt-1">Create a new attendance session for students to submit their presence</p>
            </div>

            <form action="{{ route('instruktur.attendances.store', $class) }}" method="POST" class="p-6 md:p-8 space-y-8">
                @csrf

                <div class="space-y-6">
                    <!-- Meeting Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                            Meeting Number
                        </label>
                        <input type="number" name="meeting_number" value="{{ old('meeting_number', $nextMeeting) }}" min="1" required 
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition px-4 py-3 text-gray-700 text-lg font-semibold shadow-sm">
                        @error('meeting_number')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Next available meeting: <span class="font-bold text-emerald-600">{{ $nextMeeting }}</span></p>
                    </div>

                    <!-- Attendance Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Attendance Date
                        </label>
                        <input type="date" name="attendance_date" value="{{ old('attendance_date', date('Y-m-d')) }}" required 
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition px-4 py-3 text-gray-700 shadow-sm">
                        @error('attendance_date')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Info Card -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <p class="font-semibold text-amber-800">Important Information</p>
                                <p class="text-sm text-amber-700 mt-1">After creating this session, students can submit their attendance (Present / Permission / Sick) until the day after the attendance date. The instructor can modify attendance records at any time.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6 flex justify-end gap-4">
                    <a href="{{ route('instruktur.attendances.index', $class) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>