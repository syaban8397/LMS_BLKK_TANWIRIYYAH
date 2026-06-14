<?php

namespace App\Exports\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(protected Collection $classes) {}

    public function collection(): Collection
    {
        return $this->classes;
    }

    public function headings(): array
    {
        return [
            'No', 'Kode Kelas', 'Nama Kelas', 'Program', 'Instruktur', 'Status',
            'Kuota', 'Peserta', 'Materi', 'Tugas', 'Sertifikat',
            'Tanggal Mulai', 'Tanggal Selesai',
        ];
    }

    public function map($class): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $class->code,
            $class->title,
            $class->program->name ?? '-',
            $class->instructor->name ?? '-',
            $class->status,
            $class->quota,
            $class->participants_count,
            $class->materials_count,
            $class->assignments_count,
            $class->certificates_count,
            $class->start_date?->format('Y-m-d'),
            $class->end_date?->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
