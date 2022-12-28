<?php

namespace Lib\Nakshatra;

class Storage
{
    const INDEX_LEVEL_1 = 1;
    const INDEX_LEVEL_2 = 2;

    protected $raw = [];
    protected $indexed = [];

    protected $indexLevel;

    public function __construct($filename, $indexBy)
    {
        $this->indexLevel = $indexBy;
        if ($handle = @fopen($filename, 'r')) {
            while ($data = fgetcsv($handle)) {
                $this->raw[] = $data;
            }
            fclose($handle);
        }

        $this->reindex();
    }

    public function reindex()
    {
        $this->indexed = [];
        foreach ($this->raw as $values) {
//            $nakshatra = new Model($values);
            if ($this->indexLevel == self::INDEX_LEVEL_2) {
                $this->indexed[$values[0]][$values[1]] = $values;
            }
            else {
                $this->indexed[$values[0]] = $values;
            }
        }
    }

    public function save()
    {
        $handle = fopen(self::FILENAME, 'w');
        foreach ($this->raw as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

    public function add($values)
    {
        return $this->raw[] = $values;
    }

    public function reset()
    {
        $this->raw = [];
        $this->indexed = [];
    }

    public function getSection($name)
    {
        return $this->indexed[$name];
    }
}