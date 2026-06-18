<x-app-layout>
<div class="create-material-wrapper lms-page-shell max-w-7xl mx-auto space-y-6">
        <x-lms-page-header
            title="Buat Materi Baru"
            :subtitle="'Tambahkan materi ke ' . $class->title"
            :back-url="route('instruktur.materials.index', $class)"
            back-label="← Kembali ke Materi"
        />

        <div class="form-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">
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
                            Batal
                        </a>
                        <button type="submit" class="btn-3d px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Create Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>