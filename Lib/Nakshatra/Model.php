<?php

namespace Lib\Nakshatra;

class Model
{
    const SOURCE = 0;
    const TARGET = 1;
    const INFLUENCE = 2;
    const NADI = 3;
    const TARA = 4;

    public $source;
    public $target;
    public $influence;
    public $nadi;
    public $tara;

    public function __construct($data = [])
    {
        if ($data) {
            $this->source = $data[self::SOURCE];
            $this->target = $data[self::TARGET];
            $this->influence = $data[self::INFLUENCE];
            $this->nadi = $data[self::NADI];
            $this->tara = $data[self::TARA];
        }
    }

    public function toArray()
    {
        return [
            $this->source,
            $this->target,
            $this->influence,
            $this->nadi,
            $this->tara,
        ];
    }
}