<?php

namespace Lib\Nakshatra;

class MoonPlace
{
    const USER_PLACE = 0;
    const TRANSIT_1 = 1;
    const TRANSIT_2 = 2;
    const TRANSIT_3 = 3;

    public $userPlace;
    public $transit1;
    public $transit2;
    public $transit3;

    public function __construct($data = [])
    {
        if ($data && is_array($data)) {
            $this->userPlace = $data[self::USER_PLACE];
            $this->transit1 = $data[self::TRANSIT_1];
            $this->transit2 = $data[self::TRANSIT_2];
            $this->transit3 = $data[self::TRANSIT_3];
        }
    }

    public function hasUnfavorableTransit($currentPlace)
    {
        return in_array($currentPlace, [$this->transit1, $this->transit2, $this->transit3]);
    }
}