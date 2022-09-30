<?php
const REPLACE_DICT = __DIR__ . '/dict_replace.txt';
const ADD_CONTENT_DICT = __DIR__ . '/dict_add.txt';
//print_r($argv);
require 'vendor/autoload.php';
list($script, $filename) = $argv;

$dictionary = new \Lib\Dictionary();
//$dictionary->replace($filename);

//$nakshatra = new \Lib\Nakshatra(__DIR__ . '/nadi.xlsx');
//$nakshatra->changeSheet('');
//$nakshatra->findCell('ревати');

$calendar = new \Lib\Calendar(__DIR__ . '/'. $filename);
//print_r($calendar->readRange('2022-01-01', '2022-01-03'));
//$calendar->updateEvent();
$dictionary->useDict(REPLACE_DICT);
$calendar->updateEvents([$dictionary, 'replaceContent']);

$dictionary->useDict(ADD_CONTENT_DICT);
foreach ($dictionary->dict as $item) {
    list($needle, $newPhrase) = [$item['from'], $item['to']];
    $calendar->updateEvents([$dictionary, 'addPhraseIfFound'], [$newPhrase, $needle]);
}
$calendar->write(__DIR__ .'/new.ical');




