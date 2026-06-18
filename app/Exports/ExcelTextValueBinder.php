<?php

namespace App\Exports;

use App\Support\ReportUserFields;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelTextValueBinder extends DefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value) && str_starts_with($value, ReportUserFields::EXCEL_TEXT_PREFIX)) {
            $cell->setValueExplicit(
                substr($value, strlen(ReportUserFields::EXCEL_TEXT_PREFIX)),
                DataType::TYPE_STRING
            );

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
