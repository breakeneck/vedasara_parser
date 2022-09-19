<?php

namespace Lib;

class Dictionary
{
    private $dict;
    public $content;

    public function __construct($filename)
    {
        $this->dict = array_map(function($line) {
            list($from, $to) = explode(':', $line);
            return ['from' => $from, 'to' => $to];
        }, array_filter(explode(PHP_EOL, file_get_contents($filename))));
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