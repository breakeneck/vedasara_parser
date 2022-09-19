<?php

namespace Lib;

use ICal\Event;

class CalBuilder
{
    /** @var Event[] */
    public $events;

    public function __construct($events)
    {
        $this->events = $events;
        return $this;
    }

    public function getContent()
    {
        $content = [];
        $content[] = 'BEGIN:VCALENDAR';
        $content[] = 'VERSION:2.0';
        foreach ($this->events as $event) {
            $content[] = 'BEGIN:VEVENT';
            $content[] = 'DTSTART;VALUE=DATE:' . $event->dtstart;
            $content[] = 'DTEND;VALUE=DATE:' . $event->dtend;
            $content[] = 'SUMMARY:' . ($event->summary);
            $content[] = 'DESCRIPTION:' . $this->ecranize($event->description);
            $content[] = 'END:VEVENT';
        }
        $content[] = 'END:VCALENDAR';

        return implode(PHP_EOL, $content);
    }

    private function ecranize($string)
    {
        return str_replace(["\n"], ['\n'], $string);
    }

    public function write($filename)
    {
        file_put_contents($filename, $this->getContent());
    }
}