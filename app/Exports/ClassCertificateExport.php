<?php

namespace App\Exports;

use App\Models\ClassModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassCertificateExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(
        protected ClassModel $class,
        protected array $students
    ) {}

    public function collection(): Collection
    {
        return collect($this->students);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Email',
            'Absensi (Hadir/Total)',
            'Persentase Absensi (%)',
            'Tugas Dikumpul/Total',
            'Status Kelulusan',
            'Nomor Sertifikat',
            'Tanggal Terbit',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $status = match ($row['final_grade']?->status) {
            'pass' => 'Lulus',
            'fail' => 'Tidak Lulus',
            default => 'Belum Ditentukan',
        };

        return [
            $no,
            $row['participant']->name,
            $row['participant']->email,
            $row['attendance_count'] . '/' . $row['total_meetings'],
            $row['attendance_percentage'],
            $row['submission_count'] . '/' . $row['total_assignments'],
            $status,
            $row['certificate']?->certificate_number ?? '-',
            $row['certificate']?->issued_at?->format('d/m/Y') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
