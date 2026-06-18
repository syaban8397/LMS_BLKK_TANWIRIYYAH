<?php

namespace App\Exports\Concerns;

use App\Exports\ExcelTextValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;

trait BindsExcelTextValues
{
    public function getCustomValueBinder(): IValueBinder
    {
        return new ExcelTextValueBinder();
    }

    public function bindValue(Cell $cell, $value): bool
    {
        return $this->getCustomValueBinder()->bindValue($cell, $value);
    }
}
