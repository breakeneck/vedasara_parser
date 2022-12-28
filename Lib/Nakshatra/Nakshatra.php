<?php

namespace Lib\Nakshatra;

class Nakshatra
{
    const SOURCE = 0;
    const TARGET = 1;
    const TARA = 2;
    const BALA = 3;
//    const NADI = 3;

    public $source;
    public $target;
    public $bala;
//    public $nadi;
    public $tara;

    public function __construct($data = [])
    {
        if ($data && is_array($data)) {
            $this->source = $data[self::SOURCE];
            $this->target = $data[self::TARGET];
//            $this->nadi = $data[self::NADI];
            $this->tara = $data[self::TARA];
            $this->bala = $data[self::BALA];
        }
    }

    public function toArray()
    {
        return [
            $this->source,
            $this->target,
//            $this->nadi,
            $this->tara,
            $this->bala,
        ];
    }

//    public function stripQuotes()
//    {
//        foreach (get_object_vars($this) as $attr => $value) {
//            $this->$attr = str_replace(['"', '"'], [''. ''], $value);
//        }
//        return $this;
//    }
}