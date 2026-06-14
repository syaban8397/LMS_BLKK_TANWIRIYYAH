<x-app-layout>
<div class="edit-material-wrapper max-w-7xl mx-auto">
        {{-- Tombol back di kanan atas --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('instruktur.materials.index', $class) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Materials
            </a>
        </div>

        <div class="form-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-5 py-3 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Material
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Update material information for {{ $class->title }}</p>
            </div>
            <div class="p-6">
                <form action="{{ route('instruktur.materials.update', [$class, $material]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('instruktur.materials.form')

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('instruktur.materials.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Update Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>