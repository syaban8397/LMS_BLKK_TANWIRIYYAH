<?php

namespace App\Exports\Concerns;

use App\Exports\ExcelTextValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;

trait BindsExcelTextValues
{
    public function getCustomValueBinder(): IValueBinder
    {
        return new ExcelTextValueBinder();
    }
}
