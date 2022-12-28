<?php

namespace Lib\Nakshatra;


class Parser
{
    const NAKSHATRA_SEARCH = '/Накшатра - (.*) до (.*)\\n/';
//    const NAKSHATRA_REPLACE_FROM = '/(Накшатра.*\\n)/';
    const NAKSHATRA_REPLACE_FROM = '/(Знак Сонця)/';

    const MOON_PLACE_SEARCH = '/Знак Місяця - (.*)\\n/';
    const MOON_TRANSIT_FAVOUR_FROM = '/Знак Місяця - (.*)\/';
    const MOON_TRANSIT_FAVOUR_TO = '/Знак Місяця - $1 (%s)\\n/';

    public static function retrieveNakshatra($content)
    {
        preg_match(self::NAKSHATRA_SEARCH, $content, $matches);
        return [$matches[1], $matches[2]];
    }

    public static function replaceNakshatra($content, $nadiTaraBala)
    {
        return preg_replace(self::NAKSHATRA_REPLACE_FROM, "$nadiTaraBala\\n\\n$1", $content);
    }

    public static function retrieveMoonPlace($content)
    {
        preg_match(self::MOON_PLACE_SEARCH, $content, $matches);
        return $matches[1];
    }

    public static function addMoonTransitFavour($content, $favourable)
    {
        return preg_replace(self::MOON_TRANSIT_FAVOUR_FROM, sprintf(self::MOON_TRANSIT_FAVOUR_TO, $favourable), $content);
    }
}