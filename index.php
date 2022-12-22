<?php

use Lib\Calendar;

const REPLACE_DICT = __DIR__ . '/dict_replace.txt';
const ADD_CONTENT_DICT = __DIR__ . '/dict_add.txt';
//print_r($argv);
require 'vendor/autoload.php';
list($script, $filename, $userNakshatraName) = $argv;

$dictionary = new \Lib\Dictionary();

// Parse DrikPanchang
$calendar = new Calendar(__DIR__ . '/'. $filename);

$dictionary->useDict(REPLACE_DICT);
$calendar->updateFields(Calendar::FIELD_SUMMARY, [$dictionary, 'replaceContent']);
$calendar->updateFields(Calendar::FIELD_DESCRIPTION, [$dictionary, 'replaceContent']);

//$dictionary->useDict(ADD_CONTENT_DICT);
//foreach ($dictionary->dict as $item) {
//    list($needle, $newPhrase) = [$item['from'], $item['to']];
//    $calendar->updateEvents([$dictionary, 'addPhraseIfFound'], [$newPhrase, $needle]);
//}
$dictionary->loadNakshatraDict($userNakshatraName);
$calendar->updateFields(Calendar::FIELD_DESCRIPTION, [$dictionary, 'addNakshatraDescription']);


$calendar->write(__DIR__ ."/$userNakshatraName-" . date('Y'). ".ical");


