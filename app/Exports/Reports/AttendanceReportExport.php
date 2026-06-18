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



class AttendanceReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

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

        $headings = array_merge(

            ['No'],

            ReportUserFields::minimalHeadings(),

            ['Hadir', 'Izin', 'Sakit', 'Alpha']

        );



        foreach ($this->meetings as $meeting) {

            $date = $meeting->attendance_date

                ? $meeting->attendance_date->format('Y-m-d')

                : '';

            $headings[] = 'Pertemuan ' . $meeting->meeting_number . ($date ? " ({$date})" : '');

        }



        return $headings;

    }



    public function map($row): array

    {

        static $no = 0;

        $no++;



        $participant = $row['participant'] ?? null;



        $data = array_merge(

            [$no],

            ReportUserFields::minimalRow($participant),

            [

                $row['present_count'],

                $row['permission_count'],

                $row['sick_count'],

                $row['absent_count'],

            ]

        );



        foreach ($this->meetings as $meeting) {

            $data[] = $row['attendances'][$meeting->meeting_number] ?? '';

        }



        return $data;

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

