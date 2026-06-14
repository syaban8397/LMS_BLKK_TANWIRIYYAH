<?php

namespace App\Exports\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(protected Collection $grades) {}

    public function collection(): Collection
    {
        return $this->grades;
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Peserta', 'Email', 'Kelas', 'Program', 'Instruktur',
            'Nilai Tugas', 'Nilai Absensi', 'Nilai Akhir', 'Status',
        ];
    }

    public function map($grade): array
    {
        static $no = 0;
        $no++;

        $status = match ($grade->status) {
            'pass' => 'Lulus',
            'fail' => 'Tidak Lulus',
            default => '-',
        };

        return [
            $no,
            $grade->participant->name ?? '-',
            $grade->participant->email ?? '-',
            $grade->class->title ?? '-',
            $grade->class->program->name ?? '-',
            $grade->class->instructor->name ?? '-',
            $grade->assignment_score,
            $grade->attendance_score,
            $grade->final_score,
            $status,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
