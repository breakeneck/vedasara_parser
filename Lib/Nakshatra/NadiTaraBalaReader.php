<?php

namespace Lib\Nakshatra;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NadiTaraBalaReader
{
    const FILENAME = __DIR__ . '/../../nadi.xlsx';

    const TARA_COL = 'D';
    const BALA_ROW = 3;

    /** @var \PhpOffice\PhpSpreadsheet\Spreadsheet  */
    private $spreadsheet;
    /** @var Worksheet */
    private $sheet;

    public function __construct($filename = null)
    {
        $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename ?? self::FILENAME);
    }

    public function changeSheet($name)
    {
        $this->sheet = $this->spreadsheet->getSheetByName($name);
        return $this->sheet;
    }

    public function getCurrentSheetTitle()
    {
        return $this->sheet?->getTitle();
    }

    /**
     * @param $needle
     * @return \PhpOffice\PhpSpreadsheet\Cell\Cell|void|null
     */
    public function findCell($needle)
    {
        foreach ($this->sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            foreach ($cellIterator as $cell) {
                if (stripos($cell->getValue(), $needle) !== false) {
                    return $cell;
                }
            }
        }
        return null;
    }

    public function getValue($row, $col)
    {
        return $this->sheet->getCell($col . $row)->getCalculatedValue();
    }

    /**
     * @param $cell \PhpOffice\PhpSpreadsheet\Cell\Cell
     * @return mixed
     */
    public function getNextCellValue($cell)
    {
        $nextCol = chr(ord($cell->getColumn()) + 1);
        return $this->sheet->getCell($nextCol . $cell->getRow())->getCalculatedValue();
    }
}