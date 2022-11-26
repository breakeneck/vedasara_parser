<?php

require 'vendor/autoload.php';
list($script, $userNakshatra, $currentNakshatra) = $argv;

$nakshatra = new \Lib\Nakshatra(__DIR__ . '/nadi.xlsx');
$nakshatra->changeSheet($userNakshatra);
$cell = $nakshatra->findCell($currentNakshatra);
$value = $nakshatra->getValue($cell->getRow(), \Lib\Nakshatra::DESCRIPTION_COLUMN);
echo "\n$value\n";