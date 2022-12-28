<?php

namespace Lib;

use Lib\Nakshatra\MoonPlace;
use Lib\Nakshatra\Nakshatra;
use Lib\Nakshatra\Parser;
use Lib\Nakshatra\Storage;

class Dictionary
{
    public $dict = [];
    public $content;
    public $nakshatraStorage;
    public $moonPowerStorage = [];

    public function loadNakshatraDict($filename, $userNakshatraName)
    {
        $this->nakshatraStorage = (new Storage($filename, Storage::INDEX_LEVEL_2))->getSection($userNakshatraName);
    }

    public function useDict($filename)
    {
        $this->dict = [];
        $lines = array_filter(explode(PHP_EOL, file_get_contents($filename)));
        foreach ($lines as $line) {
            if (trim($line)) {
                list($from, $to) = explode(':', $line);
                $this->dict[] = ['from' => $from, 'to' => $to];
            }
        }
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function removeReturns()
    {
         $this->content = str_replace("\r\n ", "", $this->content);
         return $this;
    }

    public function replaceContent($content)
    {
        return  str_replace(
            array_column($this->dict, 'from'),
            array_column($this->dict, 'to'),
            $content
        );
    }

    public function addPhraseIfFound($content, $phraseToAdd, $needle)
    {
        if (str_contains($content, $needle)) {
            $content .= '\n' . $phraseToAdd;
        }
        return $content;
    }

    public function addNakshatraDescription($content)
    {
        list($currentNakshatraName, $time) = Parser::retrieveNakshatra($content);
        $nakshatraModel = new Nakshatra($this->nakshatraStorage[$currentNakshatraName] ?? []);
        if ($nakshatraModel->source) {
//            $content .= '\n' . "$currentNakshatraName $nakshatraModel->tara $nakshatraModel->bala% до $time";
            $content = Parser::replaceNakshatra($content, "$currentNakshatraName, $nakshatraModel->tara $nakshatraModel->bala%");
        }
        return $content;
    }

    public function loadMoonPower($filename, $moonPlace)
    {
        $this->moonPowerStorage = (new Storage($filename, Storage::INDEX_LEVEL_1))->getSection($moonPlace);
    }

    public function addMoonOpportuneness($content)
    {
        $currentMoonPlace = Parser::retrieveMoonPlace($content);
        $moonPlaceModel = new MoonPlace($this->moonPowerStorage[$currentMoonPlace] ?? null);
        if ($moonPlaceModel->userPlace) {
            $content = Parser::addMoonTransitFavour($content, $moonPlaceModel->hasUnfavorableTransit($currentMoonPlace) ? 'несприятливо' : 'сприятливо');
        }
        return $content;
    }

    public function replace()
    {
        $this->content = str_replace(
            array_column($this->dict, 'from'),
            array_column($this->dict, 'to'),
            $this->content
        );
        return $this;
    }

    public function replaceFile($filename)
    {
        return $this
            ->loadFile($filename)
            ->removeReturns()
            ->replace()
            ->writeFile($filename);
    }

    private function loadFile($filename)
    {
        return $this->setContent(file_get_contents($filename));
    }

    private function writeFile($filename)
    {
        file_put_contents(pathinfo($filename)['filename'] .'_result.' . pathinfo($filename)['extension'], $this->content);
        return $this;
    }
}