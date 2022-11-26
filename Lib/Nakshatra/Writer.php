<?php

namespace Lib\Nakshatra;

class Writer
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

    public function process()
    {
        $parser = new XlsReader();
        $storage = new Storage();
        $storage->reset();

        foreach (self::NAMES as $userNakshatraName) {
            foreach (self::NAMES as $currentNakshatraName) {
                if ($parser->getCurrentSheetTitle() != $userNakshatraName) {
                    $parser->changeSheet($userNakshatraName);
                }
                $cell = $parser->findCell($currentNakshatraName);

                $model = new Model();
                $model->source = $userNakshatraName;
                $model->target = $currentNakshatraName;
                $model->nadi = $parser->getNextCellValue($cell);
                $model->tara = $parser->getValue($cell->getRow(), XlsReader::TARA_COL);
                $model->influence = $parser->getValue(XlsReader::INFLUENCE_ROW, $cell->getColumn());

                $storage->add($model);
            }
        }

        $storage->save();
    }
}