<?php

namespace App\Exports\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantsReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(protected Collection $participants) {}

    public function collection(): Collection
    {
        return $this->participants;
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Email', 'NIK', 'Status Akun', 'Approval', 'Jumlah Kelas', 'Sertifikat', 'Submission', 'Absensi'];
    }

    public function map($user): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $user->name,
            $user->email,
            $user->nik ?? '-',
            $user->is_active ? 'Aktif' : 'Nonaktif',
            $user->approval_status ?? '-',
            $user->class_participants_count,
            $user->certificates_count,
            $user->submissions_count,
            $user->attendances_count,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
