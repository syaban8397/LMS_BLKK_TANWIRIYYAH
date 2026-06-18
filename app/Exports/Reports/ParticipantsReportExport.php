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



class ParticipantsReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

    public function __construct(protected Collection $participants) {}



    public function collection(): Collection

    {

        return $this->participants;

    }



    public function headings(): array

    {

        return array_merge(['No'], ReportUserFields::headings());

    }



    public function map($user): array

    {

        static $no = 0;

        $no++;



        return array_merge([$no], ReportUserFields::excelRow($user));

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

