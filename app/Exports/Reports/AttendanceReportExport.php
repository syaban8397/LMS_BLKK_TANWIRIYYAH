<?php

namespace App\Exports\Reports;

use App\Models\ClassModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(
        protected ClassModel $class,
        protected Collection $meetings,
        protected array $attendanceMatrix
    ) {}

    public function collection(): Collection
    {
        return collect($this->attendanceMatrix);
    }

    public function headings(): array
    {
        $headings = ['No', 'Nama Peserta', 'Email', 'Hadir', 'Izin', 'Sakit', 'Alpha'];

        foreach ($this->meetings as $meeting) {
            $headings[] = 'Pertemuan ' . $meeting->meeting_number;
        }

        return $headings;
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $data = [
            $no,
            $row['name'],
            $row['email'],
            $row['present_count'],
            $row['permission_count'],
            $row['sick_count'],
            $row['absent_count'],
        ];

        foreach ($this->meetings as $meeting) {
            $data[] = $row['attendances'][$meeting->meeting_number] ?? '-';
        }

        return $data;
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
