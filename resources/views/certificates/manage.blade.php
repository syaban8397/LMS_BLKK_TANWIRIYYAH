@php
    $routePrefix = $routePrefix ?? 'admin.certificates';
    $downloadRoute = $downloadRoute ?? 'admin.certificates.download';
@endphp

<x-app-layout>
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Sertifikat — {{ $class->title }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ $class->program->name }} · Instruktur: {{ $class->instructor->name }}
                </p>
            </div>
            <a href="{{ route($routePrefix . '.index') }}"
               class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800">
            Centang peserta, pilih status <strong>Lulus</strong> atau <strong>Tidak Lulus</strong>, lalu simpan.
            Untuk menerbitkan sertifikat, centang peserta yang sudah lulus lalu klik <strong>Terbitkan Terpilih</strong>.
            Gelar: <strong>{{ $class->program->certificate_degree_label }}</strong>
        </div>

        <form id="certificate-form" method="POST" action="{{ route($routePrefix . '.save-statuses', $class) }}">
            @csrf

            <div class="flex flex-wrap items-center gap-3 mb-3">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    Simpan Status
                </button>
                <button type="submit"
                        formaction="{{ route($routePrefix . '.bulk-issue', $class) }}"
                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-medium"
                        onclick="return confirm('Terbitkan sertifikat untuk peserta terpilih yang sudah lulus?')">
                    Terbitkan Terpilih
                </button>
                <a href="{{ route($routePrefix . '.export', $class) }}"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    Export Excel
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">
                                <input type="checkbox" id="select-all" class="rounded border-slate-300 text-blue-600" title="Pilih semua">
                            </th>
                            <th class="px-4 py-3 text-left">Peserta</th>
                            <th class="px-4 py-3 text-center">Absensi</th>
                            <th class="px-4 py-3 text-center">Pengumpulan Tugas</th>
                            <th class="px-4 py-3 text-center">Lulus</th>
                            <th class="px-4 py-3 text-center">Tidak Lulus</th>
                            <th class="px-4 py-3 text-center">Sertifikat</th>
                            <th class="px-4 py-3 text-center">Download</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $row)
                            @php
                                $participant = $row['participant'];
                                $finalGrade = $row['final_grade'];
                                $certificate = $row['certificate'];
                                $status = $finalGrade?->status;
                                $pid = $participant->id;
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $pid }}"
                                           class="row-select rounded border-slate-300 text-blue-600">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-800">{{ $participant->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $participant->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-semibold text-blue-700">{{ $row['attendance_count'] }}</span>
                                    <span class="text-slate-400">/ {{ $row['total_meetings'] }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-semibold text-purple-700">{{ $row['submission_count'] }}</span>
                                    <span class="text-slate-400">/ {{ $row['total_assignments'] }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox"
                                           class="status-pass rounded border-green-300 text-green-600"
                                           data-participant="{{ $pid }}"
                                           {{ $status === 'pass' ? 'checked' : '' }}>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox"
                                           class="status-fail rounded border-red-300 text-red-600"
                                           data-participant="{{ $pid }}"
                                           {{ $status === 'fail' ? 'checked' : '' }}>
                                </td>
                                <td class="px-4 py-3 text-center text-xs">
                                    @if($certificate?->pdf_file)
                                        <span class="text-green-600 font-medium">Terbit</span>
                                        <div class="text-slate-400">{{ $certificate->issued_at?->format('d/m/Y') }}</div>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                    <input type="hidden" name="status[{{ $pid }}]" id="status-input-{{ $pid }}" value="{{ $status ?? '' }}">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($certificate?->pdf_file)
                                        <a href="{{ route($downloadRoute, $certificate) }}"
                                           class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">PDF</a>
                                    @else
                                        <span class="text-slate-300 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="py-10 text-center text-slate-400">Belum ada peserta di kelas ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const rowSelects = document.querySelectorAll('.row-select');

            function syncHiddenInput(participantId) {
                const passCb = document.querySelector('.status-pass[data-participant="' + participantId + '"]');
                const failCb = document.querySelector('.status-fail[data-participant="' + participantId + '"]');
                const hidden = document.getElementById('status-input-' + participantId);
                if (!hidden) return;

                if (passCb?.checked) hidden.value = 'pass';
                else if (failCb?.checked) hidden.value = 'fail';
                else hidden.value = '';
            }

            document.querySelectorAll('.status-pass').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    const id = this.dataset.participant;
                    if (this.checked) {
                        const failCb = document.querySelector('.status-fail[data-participant="' + id + '"]');
                        if (failCb) failCb.checked = false;
                    }
                    syncHiddenInput(id);
                });
            });

            document.querySelectorAll('.status-fail').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    const id = this.dataset.participant;
                    if (this.checked) {
                        const passCb = document.querySelector('.status-pass[data-participant="' + id + '"]');
                        if (passCb) passCb.checked = false;
                    }
                    syncHiddenInput(id);
                });
            });

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    rowSelects.forEach(function (cb) {
                        cb.checked = selectAll.checked;
                    });
                });
            }

            rowSelects.forEach(function (cb) {
                cb.addEventListener('change', function () {
                    if (!selectAll) return;
                    const allChecked = Array.from(rowSelects).every(function (r) { return r.checked; });
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = !allChecked && Array.from(rowSelects).some(function (r) { return r.checked; });
                });
            });

            document.querySelectorAll('[id^="status-input-"]').forEach(function (input) {
                const id = input.id.replace('status-input-', '');
                syncHiddenInput(id);
            });
        });
    </script>
</x-app-layout>