<x-app-layout>
    {{-- Header dengan tombol back --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pb-4 border-b border-slate-200 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Create New Material</h1>
            <p class="text-sm text-slate-500 mt-1">Add a new material to {{ $class->title }}</p>
        </div>
        <div>
            <a href="{{ route('instruktur.materials.index', $class) }}" class="btn-3d inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Materials
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="dashboard-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Material Information
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Fill in the details below</p>
            </div>
            <div class="p-6">
                <form action="{{ route('instruktur.materials.store', $class) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @include('instruktur.materials.form')

                    {{-- Action Buttons --}}
                    <div class="border-t border-slate-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('instruktur.materials.index', $class) }}" class="btn-3d px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Create Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>