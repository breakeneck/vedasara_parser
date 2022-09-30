<?php

namespace Lib;

class Dictionary
{
    public $dict = [];
    public $content;

    public function useDict($filename)
    {
        $lines = array_filter(explode(PHP_EOL, file_get_contents($filename)));
        foreach ($lines as $line) {
            if (trim($line)) {
                list($from, $to) = explode(':', $line);
                $this->dict[] = [$from => $to];
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
            array_keys($this->dict),
            array_values($this->dict),
            $content
        );
    }

    public function addPhraseIfFound($content, $phraseToAdd, $needle)
    {
        if (str_contains($content, $needle)) {
            $content .= $phraseToAdd;
        }
        return $content;
    }

    public function replace()
    {
        $this->content = str_replace(
            array_keys($this->dict),
            array_values($this->dict),
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