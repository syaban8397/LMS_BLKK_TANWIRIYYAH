<?php

namespace App\Exports\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CertificatesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(protected Collection $certificates) {}

    public function collection(): Collection
    {
        return $this->certificates;
    }

    public function headings(): array
    {
        return [
            'No', 'Nomor Sertifikat', 'Nama Peserta', 'Email', 'Kelas', 'Program',
            'Instruktur', 'Nilai Akhir', 'Persentase Absensi', 'Tanggal Terbit',
        ];
    }

    public function map($certificate): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $certificate->certificate_number,
            $certificate->participant->name ?? '-',
            $certificate->participant->email ?? '-',
            $certificate->class->title ?? '-',
            $certificate->class->program->name ?? '-',
            $certificate->class->instructor->name ?? '-',
            $certificate->final_score,
            $certificate->attendance_percentage,
            $certificate->issued_at?->format('d/m/Y') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
