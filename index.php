<?php
const REPLACE_DICT = __DIR__ . '/dict_replace.txt';
const ADD_CONTENT_DICT = __DIR__ . '/dict_add.txt';
//print_r($argv);
require 'vendor/autoload.php';
list($script, $filename, $userNakshatraName) = $argv;

$dictionary = new \Lib\Dictionary();

// Parse DrikPanchang
$calendar = new \Lib\Calendar(__DIR__ . '/'. $filename);

$dictionary->useDict(REPLACE_DICT);
$calendar->updateEvents([$dictionary, 'replaceContent']);

//$dictionary->useDict(ADD_CONTENT_DICT);
//foreach ($dictionary->dict as $item) {
//    list($needle, $newPhrase) = [$item['from'], $item['to']];
//    $calendar->updateEvents([$dictionary, 'addPhraseIfFound'], [$newPhrase, $needle]);
//}
$dictionary->loadNakshatraDict($userNakshatraName);
$calendar->updateEvents([$dictionary, 'addNakshatraDescription']);


$calendar->write(__DIR__ ."/$userNakshatraName-" . date('Y'). ".ical");




