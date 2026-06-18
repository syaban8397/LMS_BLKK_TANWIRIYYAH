@php
    $routePrefix = $routePrefix ?? 'admin.certificates';
    $downloadRoute = $downloadRoute ?? 'admin.certificates.download';
@endphp

<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header
            :title="'Sertifikat — ' . $class->title"
            :subtitle="$class->program->name . ' · Instruktur: ' . $class->instructor->name"
            :back-url="route($routePrefix . '.index')"
        />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800">
            Centang peserta → pilih status <strong>Lulus</strong> / <strong>Tidak Lulus</strong> (per baris atau massal) → klik <strong>Confirm</strong> untuk menyimpan.
            Peserta lulus dapat diterbitkan sertifikat via <strong>Terbitkan Terpilih</strong>.
            Gelar: <strong>{{ $class->program->certificate_degree_label }}</strong>
        </div>

        <form id="certificate-form" method="POST" action="{{ route($routePrefix . '.save-statuses', $class) }}">
            @csrf

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-3">
                <div class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status Massal (peserta tercentang)</label>
                        <select id="bulk-status" class="rounded-lg border-slate-200 text-sm px-3 py-2 min-w-[160px]">
                            <option value="">— Pilih Status —</option>
                            <option value="pass">Lulus</option>
                            <option value="fail">Tidak Lulus</option>
                        </select>
                    </div>
                    <button type="button" id="apply-bulk-status"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                        Terapkan ke Terpilih
                    </button>
                    <div class="flex-1"></div>
                    <button type="submit" id="confirm-save"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm"
                            data-lms-confirm="Simpan status kelulusan semua peserta?">
                        Confirm
                    </button>
                    <button type="submit"
                            formaction="{{ route($routePrefix . '.bulk-issue', $class) }}"
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-medium"
                            data-lms-confirm="Terbitkan sertifikat untuk peserta terpilih yang sudah lulus?">
                        Terbitkan Terpilih
                    </button>
                    <a href="{{ route($routePrefix . '.export', $class) }}"
                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                        Export Excel
                    </a>
                </div>
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
                            <th class="px-4 py-3 text-center w-44">Status Kelulusan</th>
                            <th class="px-4 py-3 text-center">Sertifikat</th>
                            <th class="px-4 py-3 text-center">Unduh</th>
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
                                    <select name="status[{{ $pid }}]"
                                            class="status-select rounded-lg border-slate-200 text-sm px-2 py-1.5 w-full max-w-[140px] mx-auto"
                                            data-participant="{{ $pid }}">
                                        <option value="" {{ empty($status) ? 'selected' : '' }}>— Belum —</option>
                                        <option value="pass" {{ $status === 'pass' ? 'selected' : '' }}>Lulus</option>
                                        <option value="fail" {{ $status === 'fail' ? 'selected' : '' }}>Tidak Lulus</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 text-center text-xs">
                                    @if($certificate?->pdf_file)
                                        <span class="text-green-600 font-medium">Terbit</span>
                                        <div class="text-slate-400">{{ $certificate->issued_at?->format('d/m/Y') }}</div>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
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
                            <tr><td colspan="7" class="py-10 text-center text-slate-400">Belum ada peserta di kelas ini.</td></tr>
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
            const bulkStatus = document.getElementById('bulk-status');
            const applyBulkBtn = document.getElementById('apply-bulk-status');

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

            if (applyBulkBtn && bulkStatus) {
                applyBulkBtn.addEventListener('click', function () {
                    const value = bulkStatus.value;

                    if (!value) {
                        window.LmsDialog.alert('Pilih status Lulus atau Tidak Lulus terlebih dahulu.');
                        return;
                    }

                    const selected = Array.from(rowSelects).filter(function (cb) { return cb.checked; });

                    if (selected.length === 0) {
                        window.LmsDialog.alert('Centang minimal satu peserta.');
                        return;
                    }

                    selected.forEach(function (cb) {
                        const row = cb.closest('tr');
                        const statusSelect = row?.querySelector('.status-select');
                        if (statusSelect) {
                            statusSelect.value = value;
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>
