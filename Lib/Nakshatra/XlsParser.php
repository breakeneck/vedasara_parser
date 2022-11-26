<?php

namespace Lib\Nakshatra;

class XlsParser
{
    const NAMES = [
        'Ашвини',
        'Бхарани',
        'Критика',
        'Рохини',
        'Мригашира',
        'Аридра',
        'Пунарвасу',
        'Пушья',
        'Ашлеша',
        'Магха',
        'Пурва Пхалгуни',
        'Уттара Пхалгуни',
        'Хаста',
        'Читра',
        'Свати',
        'Вишакха',
        'Анурадха',
        'Джйештха',
        'Мула',
        'Пурва Ашадха',
        'Уттара Ашадха',
        'Шравана',
        'Дхаништха',
        'Шатабхиша',
        'Пурва Бхадра',
        'Уттара Бхадра',
        'Ревати',
    ];

    public function saveToStorage($filename = null): void
    {
        $reader = new XlsReader($filename);

        $storage = new Storage();
        $storage->reset();

        foreach (self::NAMES as $userNakshatraName) {
            foreach (self::NAMES as $currentNakshatraName) {
                if ($reader->getCurrentSheetTitle() != $userNakshatraName) {
                    $reader->changeSheet($userNakshatraName);
                }
                $cell = $reader->findCell($currentNakshatraName);
                list($row, $col) = [$cell->getRow(), $cell->getColumn()];

                $model = new Model();
                $model->source = $userNakshatraName;
                $model->target = $currentNakshatraName;
                $model->nadi = $reader->getNextCellValue($cell);
                $model->tara = $reader->getValue($row, XlsReader::TARA_COL);
                $model->influence = intval($reader->getValue(XlsReader::INFLUENCE_ROW, $col));

                $storage->add($model);
            }
        }

        $storage->save();
    }
}