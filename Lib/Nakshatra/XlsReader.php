<?php

namespace Lib\Nakshatra;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XlsReader
{
    const FILENAME = __DIR__ . '/../../nadi.xlsx';

    const TARA_COL = 'K';
    const INFLUENCE_ROW = 4;

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
        //preg_match('/Накшатра(.*)до/', $content, $matches);

        foreach ($this->sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            foreach ($cellIterator as $cell) {
                if (strpos($cell->getValue(), $needle) !== false) {
                    return $cell;
                        //[$cell->getRow(), $cell->getColumn()];
                        //$cell->getCoordinate();
        //            echo $cell->getRow() ."\n";
//                    return $this->sheet->getCell('K' . $cell->getRow())->getValue();
                }
            }
        }
    }

    public function getValue($row, $col)
    {
//        return $this->sheet->getCellByColumnAndRow($col, $row)->getValue();
        return $this->sheet->getCell($col . $row)->getValue();
    }

    /**
     * @param $cell \PhpOffice\PhpSpreadsheet\Cell\Cell
     * @return mixed
     */
    public function getNextCellValue($cell)
    {
        $nextCol = chr(ord($cell->getColumn()) + 1);
        return $this->sheet->getCell($nextCol . $cell->getRow())->getValue();
    }
}