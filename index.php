<?php 
//print_r($argv);
require 'vendor/autoload.php';
list($script, $filename) = $argv;

$dictionary = new \Lib\Dictionary(__DIR__ . '/dict.txt');
//$dictionary->replace($filename);

//$nakshatra = new \Lib\Nakshatra(__DIR__ . '/nadi.xlsx');
//$nakshatra->changeSheet('');
//$nakshatra->findCell('ревати');

$calendar = new \Lib\Calendar(__DIR__ . '/'. $filename);
//print_r($calendar->readRange('2022-01-01', '2022-01-03'));
//$calendar->updateEvent();
$calendar->updateEvents([$dictionary,'replaceContent']);
$calendar->write(__DIR__ .'/new.ical');




