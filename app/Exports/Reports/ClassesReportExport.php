<?php



namespace App\Exports\Reports;

use App\Exports\Concerns\BindsExcelTextValues;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStyles;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class ClassesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

    public function __construct(protected Collection $classes) {}



    public function collection(): Collection

    {

        return $this->classes;

    }



    public function headings(): array

    {

        return [

            'No',

            'Kode Kelas',

            'Nama Kelas',

            'Deskripsi',

            'Program',

            'Instruktur',

            'Status',

            'Kuota',

            'Jumlah Peserta',

            'Jumlah Materi',

            'Jumlah Tugas',

            'Jumlah Sertifikat',

            'Jumlah Sesi Kehadiran',

            'Detail Sesi (No|Tanggal)',

            'Tanggal Mulai',

            'Tanggal Selesai',

            'Dibuat Pada',

            'Diperbarui Pada',

        ];

    }



    public function map($class): array

    {

        static $no = 0;

        $no++;



        $sessions = $class->meeting_sessions ?? collect();

        $sessionDetail = $sessions

            ->map(function ($meeting) {

                $date = $meeting->attendance_date

                    ? $meeting->attendance_date->format('Y-m-d H:i:s')

                    : '';



                return $meeting->meeting_number . '|' . $date;

            })

            ->implode('; ');



        return [

            $no,

            $class->code,

            $class->title,

            $class->description ?? '',

            $class->program->name ?? '',

            $class->instructor->name ?? '',

            $class->status,

            $class->quota,

            $class->participants_count,

            $class->materials_count,

            $class->assignments_count,

            $class->certificates_count,

            $sessions->count(),

            $sessionDetail,

            $class->start_date ? $class->start_date->format('Y-m-d') : '',

            $class->end_date ? $class->end_date->format('Y-m-d') : '',

            $class->created_at ? $class->created_at->format('Y-m-d H:i:s') : '',

            $class->updated_at ? $class->updated_at->format('Y-m-d H:i:s') : '',

        ];

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

