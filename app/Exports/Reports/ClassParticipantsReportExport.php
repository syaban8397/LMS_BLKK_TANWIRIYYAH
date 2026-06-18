<?php



namespace App\Exports\Reports;

use App\Exports\Concerns\BindsExcelTextValues;
use App\Models\ClassModel;
use App\Support\ReportUserFields;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStyles;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class ClassParticipantsReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

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

        return array_merge(

            ['No'],

            ReportUserFields::headings(),

            [

                'Absensi (Hadir/Total)',

                'Persentase Absensi (%)',

                'Tugas Dikumpul/Total',

                'Status Kelulusan',

            ]

        );

    }



    public function map($row): array

    {

        static $no = 0;

        $no++;



        $status = $row['final_grade']?->status ?? '';



        return array_merge(

            [$no],

            ReportUserFields::excelRow($row['participant']),

            [

                $row['attendance_count'] . '/' . $row['total_meetings'],

                $row['attendance_percentage'],

                $row['submission_count'] . '/' . $row['total_assignments'],

                $status,

            ]

        );

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

