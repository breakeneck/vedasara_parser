<?php

require 'vendor/autoload.php';

use Jyotish\Panchanga\Nakshatra\Nakshatra;
use Jyotish\Panchanga\Panchanga;

//use Jyotish\Panchanga\Panchanga;

//$panchanga = Panchanga::getInstance(Panchanga::ANGA_NAKSHATRA, 1);
//$panchanga;

$data = new \Jyotish\Base\Data(
    new DateTime(),
    new \Jyotish\Base\Locality([
        'latitude' => '50.747233',
        'longitude' => '25.325383'
    ]),
    new \Jyotish\Ganita\Method\Swetest([
        'swetest' => __DIR__ . '/Jyotish/bin/swetest' . (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '.exe' : '')
    ])
);

$result = $data->calcPanchanga([Panchanga::ANGA_NAKSHATRA]);
print_r($result->getData([\Jyotish\Base\Data::BLOCK_PANCHANGA]));