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



class CertificatesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    use BindsExcelTextValues;

    public function __construct(protected Collection $certificates) {}



    public function collection(): Collection

    {

        return $this->certificates;

    }



    public function headings(): array

    {

        return array_merge(

            ['No', 'Nomor Sertifikat'],

            ReportUserFields::minimalHeadings(),

            [

                'Kode Kelas',

                'Kelas',

                'Program',

                'Instruktur',

                'Nilai Akhir',

                'Persentase Absensi',

                'Tanggal Terbit',

                'File PDF',

                'QR Code',

            ]

        );

    }



    public function map($certificate): array

    {

        static $no = 0;

        $no++;



        return array_merge(

            [

                $no,

                ReportUserFields::excelText($certificate->certificate_number ?? ''),

            ],

            ReportUserFields::minimalRow($certificate->participant),

            [

                $certificate->class->code ?? '',

                $certificate->class->title ?? '',

                $certificate->class->program->name ?? '',

                $certificate->class->instructor->name ?? '',

                $certificate->final_score ?? '',

                $certificate->attendance_percentage ?? '',

                $certificate->issued_at ? $certificate->issued_at->format('Y-m-d H:i:s') : '',

                $certificate->pdf_file ?? '',

                $certificate->qr_code ?? '',

            ]

        );

    }



    public function styles(Worksheet $sheet): array

    {

        return [1 => ['font' => ['bold' => true]]];

    }

}

