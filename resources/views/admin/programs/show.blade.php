<x-app-layout>
<div class="show-program-wrapper lms-page-shell space-y-5">
        <x-lms-page-header
            :title="$program->name"
            subtitle="Ringkasan program pelatihan"
            :back-url="route('admin.programs.index')"
        >
            <x-slot:actions>
                @if($program->status == 'active')
                    <span class="lms-badge lms-badge--success">Aktif</span>
                @else
                    <span class="lms-badge">Nonaktif</span>
                @endif
                <a href="{{ route('admin.programs.edit', $program) }}" class="lms-btn-warning btn-3d">✏️ Edit</a>
            </x-slot:actions>
        </x-lms-page-header>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Kelas</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $program->classes()->count() }}</p>
                    </div>
                    <div class="text-xl">🏫</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Dibuat Pada</p>
                        <p class="text-sm font-semibold text-green-700 mt-1">{{ $program->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">📅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Terakhir Diperbarui</p>
                        <p class="text-sm font-semibold text-purple-600 mt-1">{{ $program->updated_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-xl">🔄</div>
                </div>
            </div>
        </div>

        {{-- Program Information --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span>📋</span> Informasi Program
            </h3>
            <div class="grid md:grid-cols-2 gap-x-5 gap-y-4 text-sm">
                <div>
                    <span class="text-slate-400 text-xs">Nama Program</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Aktif Kelas</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Gelar Sertifikat</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->certificate_degree_label }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Masa Berlaku Sertifikat</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->validity_years ?? config('certificate.default_validity_years') }} tahun</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Tanggal Mulai</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->start_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Tanggal Selesai</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->end_date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-slate-400 text-xs">Kapasitas Kelas</span>
                    <p class="font-medium text-slate-800 mt-0.5">{{ $program->classCount() }}/{{ $program->capacity }} kelas</p>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-base font-semibold text-slate-800 mb-2 flex items-center gap-2">
                <span>📝</span> Deskripsi Program
            </h3>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $program->description ?: 'Tidak ada deskripsi.' }}</p>
        </div>

        {{-- Action Buttons --}}
        <div class="info-card bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.programs.edit', $program) }}" 
                   class="btn-action px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                    ✏️ Edit Program
                </a>
                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" data-lms-confirm="Hapus program pelatihan ini?" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        🗑️ Hapus Program
                    </button>
                </form>
                <a href="{{ route('admin.programs.index') }}" 
                   class="btn-action px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition shadow-sm">
                    ← Kembali ke Program
                </a>
            </div>
        </div>
    </div>
</x-app-layout>