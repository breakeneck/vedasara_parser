<?php

namespace Lib\Nakshatra;

class Storage
{
    const FILENAME = __DIR__ . '/../../nadi.csv';

    protected $raw = [];
    protected $indexed = [];

    public function __construct()
    {
        if ($handle = @fopen(self::FILENAME, 'r')) {
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
            $nakshatra = new Model($values);
            $this->indexed[$nakshatra->source][$nakshatra->target] = $nakshatra;
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

    public function add(Model $nakshatra)
    {
        return $this->raw[] = $nakshatra->toArray();
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