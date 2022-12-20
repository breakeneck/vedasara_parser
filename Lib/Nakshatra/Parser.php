<?php

namespace Lib\Nakshatra;


class Parser
{
    const NAKSHATRA_REGEX = '/Накшатра - (.*) до/';

    public static function retrieveNakshatra($content)
    {
        preg_match(self::NAKSHATRA_REGEX, $content, $matches);
        return $matches[1] ?? null;
    }
}