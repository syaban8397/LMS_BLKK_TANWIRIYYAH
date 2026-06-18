<?php



namespace App\Exports\Reports;

use App\Exports\Concerns\BindsExcelTextValues;
use App\Support\ReportUserFields;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStyles;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class GradesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

    public function __construct(protected Collection $grades) {}



    public function collection(): Collection

    {

        return $this->grades;

    }



    public function headings(): array

    {

        return array_merge(

            ['No'],

            ReportUserFields::minimalHeadings(),

            [

                'Kode Kelas',

                'Kelas',

                'Program',

                'Instruktur',

                'Nilai Tugas',

                'Nilai Absensi',

                'Nilai Akhir',

                'Status Kelulusan',

                'Umpan Balik',

            ]

        );

    }



    public function map($grade): array

    {

        static $no = 0;

        $no++;



        return array_merge(

            [$no],

            ReportUserFields::minimalRow($grade->participant),

            [

                $grade->class->code ?? '',

                $grade->class->title ?? '',

                $grade->class->program->name ?? '',

                $grade->class->instructor->name ?? '',

                $grade->assignment_score ?? '',

                $grade->attendance_score ?? '',

                $grade->final_score ?? '',

                $grade->status ?? '',

                $grade->feedback ?? '',

            ]

        );

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

