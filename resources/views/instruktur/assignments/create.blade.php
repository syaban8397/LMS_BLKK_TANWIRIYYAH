<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 -mx-6 -mt-6 px-6 py-12 rounded-b-3xl shadow-2xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-full px-3 py-1 text-xs text-white mb-3">
                        <span class="animate-pulse">●</span> Assignment Manager
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">Create Assignment</h1>
                    <p class="text-indigo-100 mt-2 text-sm md:text-base">Add a new assignment to <span class="font-semibold">{{ $class->title }}</span></p>
                </div>
                <a href="{{ route('instruktur.classes.stream', $class) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white font-medium hover:bg-white/20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Stream
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-5 border-b border-purple-100">
                <h3 class="font-black text-xl text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Assignment Details
                </h3>
                <p class="text-gray-500 text-sm mt-1">Fill in the information below to create a new task for students</p>
            </div>

            <form action="{{ route('instruktur.assignments.store', $class) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
                @csrf

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                            Assignment Title
                        </label>
                        <input type="text" name="title" placeholder="e.g., Essay on Web Development" required
                            class="w-full rounded-xl border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-200 transition px-4 py-3 text-gray-700 shadow-sm">
                        @error('title')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            Description
                        </label>
                        <textarea name="description" rows="5" placeholder="Detailed description of the assignment..." required
                            class="w-full rounded-xl border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-200 transition px-4 py-3 text-gray-700 shadow-sm"></textarea>
                        @error('description')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            Attachment (Optional)
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 transition cursor-pointer bg-gray-50/50">
                            <input type="file" name="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center py-8 px-4">
                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="text-sm text-gray-500">Click or drag to upload a file</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, PPT, ZIP (Max 100MB)</p>
                            </div>
                        </div>
                        @error('attachment')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Deadline
                        </label>
                        <input type="datetime-local" name="deadline" required
                            class="w-full rounded-xl border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-200 transition px-4 py-3 text-gray-700 shadow-sm">
                        @error('deadline')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Students cannot submit after the deadline</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6 flex justify-end gap-4">
                    <a href="{{ route('instruktur.classes.stream', $class) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>