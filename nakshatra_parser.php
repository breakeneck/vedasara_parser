<?php

require 'vendor/autoload.php';
list($script) = $argv;

$parser = new \Lib\Nakshatra\NadiTaraBalaParser();
$parser->saveToStorage();