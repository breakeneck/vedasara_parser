<?php

use Lib\Calendar;

const REPLACE_DICT = __DIR__ . '/dict_replace.txt';
const MOON_POWER = __DIR__ . '/moonpower.csv';
const NADI = __DIR__ . '/nadi.csv';

require 'vendor/autoload.php';
list($script, $filename, $userNakshatraName, $moonPlace) = $argv;

$dictionary = new \Lib\Dictionary();

// Parse DrikPanchang
$calendar = new Calendar(__DIR__ . '/'. $filename);

$dictionary->useDict(REPLACE_DICT);
$calendar->updateFields(Calendar::FIELD_SUMMARY, [$dictionary, 'replaceContent']);
$calendar->updateFields(Calendar::FIELD_DESCRIPTION, [$dictionary, 'replaceContent']);

$dictionary->loadNakshatraDict(NADI, $userNakshatraName);
$calendar->updateFields(Calendar::FIELD_DESCRIPTION, [$dictionary, 'addNakshatraDescription']);

$dictionary->loadMoonPower(MOON_POWER, $moonPlace);
$calendar->updateFields(Calendar::FIELD_DESCRIPTION, [$dictionary, 'addMoonOpportuneness']);

$calendar->write(__DIR__ ."/$userNakshatraName-" . date('Y'). ".ical");


