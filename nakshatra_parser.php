<?php

require 'vendor/autoload.php';
list($script) = $argv;

$parser = new \Lib\Nakshatra\XlsParser();
$parser->saveToStorage();