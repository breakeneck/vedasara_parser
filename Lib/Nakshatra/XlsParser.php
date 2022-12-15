<?php

namespace Lib\Nakshatra;

class XlsParser
{
//    const NAMES = [
//        'Ашвини',
//        'Бхарани',
//        'Криттика',
//        'Рохини',
//        'Мригашира',
//        'Ардра',
//        'Пунарвасу',
//        'Пушья',
//        'Ашлеша',
//        'Магха',
//        'Пурва-пхалгуни',
//        'Уттара-пхалгуни',
//        'Хаста',
//        'Читра',
//        'Свати',
//        'Вишакха',
//        'Анурадха',
//        'Джйештха',
//        'Мула',
//        'Пурва-ашадха',
//        'Уттара-ашадха',
//        'Шравана',
//        'Дхаништха',
//        'Шатабхиша',
//        'Пурва-бхадра',
//        'Уттара-бхадра',
//        'Ревати',
//    ];
    const NAMES = [
        'Ашвіні',
        'Бхарані',
        'Крітіка',
        'Рохіні',
        'Мрігашіра',
        'Арідра',
        'Пунарвасу',
        'Пушйа',
        'Ашлеша',
        'Магха',
        'Пурва Пхалгуні',
        'Уттара Пхалгуні',
        'Хаста',
        'Чітра',
        'Сваті',
        'Вішакха',
        'Анурадха',
        'Джйештха',
        'Мула',
        'Пурва Ашадха',
        'Уттара Ашадха',
        'Шравана',
        'Дханіштха',
        'Шатабхіша',
        'Пурва Бхадра',
        'Уттара Бхадра',
        'Реваті',
    ];

    public function saveToStorage($filename = null): void
    {
        $reader = new XlsReader($filename);

        $storage = new Storage();
        $storage->reset();

        foreach (self::NAMES as $n => $userNakshatraName) {
            if ($reader->getCurrentSheetTitle() != $userNakshatraName) {
                if (! $reader->changeSheet($userNakshatraName)) {
//                        throw new \Exception("Sheet $userNakshatraName not found");
                    echo ("SHEET $userNakshatraName not found\n");
                    continue;
                }
            }
            foreach (self::NAMES as $currentNakshatraName) {
                if (! $cell = $reader->findCell($currentNakshatraName)) {
                    echo "Cell $currentNakshatraName for sheet $userNakshatraName not found\n";
                    continue;
                }

                list($row, $col) = [$cell->getRow(), $cell->getColumn()];

                $model = new Model();
                $model->source = $userNakshatraName;
                $model->target = $currentNakshatraName;
//                $model->nadi = $reader->getNextCellValue($cell);
                $model->tara = $reader->getValue($row, XlsReader::TARA_COL);
                $model->bala = intval($reader->getValue(XlsReader::BALA_ROW, $col));

                $storage->add($model);
            }
        }

        $storage->save();
    }
}