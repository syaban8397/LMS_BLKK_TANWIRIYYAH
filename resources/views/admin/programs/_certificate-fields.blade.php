@php
    $degreeOptions = \App\Models\Program::certificateDegreeOptions();
    $selectedDegree = old('certificate_degree', $program->certificate_degree ?? '');
@endphp

<div class="input-group">
    <label class="block text-xs font-medium text-slate-500 mb-1">Gelar Sertifikat</label>
    <select name="certificate_degree" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
        <option value="">— Pilih Gelar —</option>
        @foreach($degreeOptions as $code => $degree)
            <option value="{{ $code }}" {{ $selectedDegree === $code ? 'selected' : '' }}>
                {{ $degree['label'] }}
            </option>
        @endforeach
    </select>
    @error('certificate_degree')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="input-group">
    <label class="block text-xs font-medium text-slate-500 mb-1">Masa Berlaku Sertifikat (tahun)</label>
    <input type="number" name="validity_years"
           value="{{ old('validity_years', $program->validity_years ?? config('certificate.default_validity_years')) }}"
           min="1" max="10"
           class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
    @error('validity_years')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="input-group">
    <label class="block text-xs font-medium text-slate-500 mb-1">Aktif Kelas</label>
    <select name="status" class="input-3d w-full rounded-lg border-slate-200 focus:border-blue-400 focus:ring-blue-400 text-sm">
        <option value="active" {{ old('status', $program->status ?? 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
        <option value="inactive" {{ old('status', $program->status ?? '') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('status')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
