<?php

namespace Lib\Nakshatra;


class Parser
{
    const NAKSHATRA_SEARCH = '/Накшатра - (.*) до (.*)\\n/';
    const NAKSHATRA_REPLACE_FROM = '/(Накшатра.*\\n)/';
    const NAKSHATRA_REPLACE_TO = '$1';

    public static function retrieveNakshatra($content)
    {
//        $content = "DESCRIPTION:Схід Сонця - 08:19\nЗахід Сонця - 16:16\nСхід Місяця - 08:44\nЗахід Місяця - 15:50\nShaka Samvat - 1944 Shubhakrit\n\nGujarati Samvat - 2079 Aananda\n Аманта Місяць - Маргашірша\nПурнімата Місяць - Пауша\n\nДень Тижня - П'ятниця\nПакша - Крішна Пакша\nТітхі - Амавасьядо 12:16\nНакшатра - Мула до 21:43\nЙога - Ганда до 10:12\nЙога - Врідхі до 05:57, Грудень24\nКарана - Нагавадо 12:16\nКарана - Кінстугхнадо 22:27\n\nЗнак Сонця - Стрілець\nЗнак Місяця - Стрілець\n\nЙога - Плечі, Руки, Верхні дихальні шляхи\n\nРАХУ КАЛА - 11:18 до 12:18\nГуліка Калам - 09:19 до 10:18\nЙамаганда - 14:17 до 15:17\nАБХІДЖІТ МУХУРТА - 12:02 до 12:34\nДур Мухурта - 09:55 до 10:26\nДур Мухурта - 12:34 до 13:05\nАмріт Калам - 16:04 до 17:29\nВарйам - 20:18 до 21:43\nВарйам - 06:08 до 07:32, Грудень24\n\nПодії по Індійському календарю\nХануман Джайанті*Таміл\nІшті\nПауша Амавасйа\n\nwww.drikpanchang.com\nМула Багатсво 10%";
        preg_match(self::NAKSHATRA_SEARCH, $content, $matches);
//        $nadiTaraBala = "Небезпека для здоров'я 100%";
//        $result = preg_replace(self::NAKSHATRA_REPLACE_FROM, self::NAKSHATRA_REPLACE_TO . $nadiTaraBala .'\\n', $content);
//        print_r($result);return;
//        print_r($matches);
        return [$matches[1], $matches[2]];
    }

    public static function replaceNakshatra($content, $nadiTaraBala)
    {
        return preg_replace(self::NAKSHATRA_REPLACE_FROM, self::NAKSHATRA_REPLACE_TO . $nadiTaraBala .'\\n', $content);
    }
}