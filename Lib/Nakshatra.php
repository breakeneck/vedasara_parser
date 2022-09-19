<?php

namespace Lib;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Nakshatra
{
    /** @var \PhpOffice\PhpSpreadsheet\Spreadsheet  */
    private $spreadsheet;
    /** @var Worksheet */
    private $sheet;

    public function __construct($filename)
    {
        $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
    }

    public function changeSheet($name)
    {
        $this->sheet = $this->spreadsheet->getSheetByName($name);
    }

    public function findCell($needle)
    {
        //preg_match('/Накшатра(.*)до/', $content, $matches);

        foreach ($this->sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            foreach ($cellIterator as $cell) {
                if (strpos($cell->getValue(), $needle) !== false) {
                    return $cell->getCoordinate();
        //            echo $cell->getRow() ."\n";
//                    return $this->sheet->getCell('K' . $cell->getRow())->getValue();
                }
            }
        }
    }

}