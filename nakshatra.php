<?php

require 'vendor/autoload.php';
list($script, $userNakshatra, $currentNakshatra) = $argv;

$nakshatra = new \Lib\NakshatraParser(__DIR__ . '/nadi.xlsx');
$nakshatra->changeSheet($userNakshatra);
$cell = $nakshatra->findCell($currentNakshatra);
$value = $nakshatra->getValue($cell->getRow(), \Lib\NakshatraParser::TARA_COL);
echo "\n$value\n";