<?php

namespace Lib;

use ICal\Event;
use ICal\ICal;

class Calendar
{
    const FIELD_DESCRIPTION = 'description';
    const FIELD_SUMMARY = 'summary';
    /** @var ICal  */
    private $ical;
    private $events;

    public function __construct($filename)
    {
        $this->ical = new ICal($filename, array(
            'defaultSpan'                 => 2,     // Default value
            'defaultTimeZone'             => 'UTC',
            'defaultWeekStart'            => 'MO',  // Default value
            'disableCharacterReplacement' => false, // Default value
            'filterDaysAfter'             => null,  // Default value
            'filterDaysBefore'            => null,  // Default value
            'httpUserAgent'               => null,  // Default value
            'skipRecurrence'              => false, // Default value
        ));
        $this->events = $this->ical->events();
    }

//    public function readRange($from, $to)
//    {
//        /** @var Event[] */
//        $events = $this->ical->eventsFromRange($from, $to);
//
//        $result = [];
//        foreach($events as $event) {
//            $result[] = $this->parseEvent($event);
//        }
//        return $result;
//    }

    public function updateFields($field, $callback, $arguments = [])
    {
        foreach ($this->events as $i => $event) {
            $this->events[$i]->$field = call_user_func_array($callback, array_merge([$event->$field], $arguments));
        }
//        $this->events[0]->description = 'Hello World';
        return $this;
    }

    public function write($filename)
    {
        $newCal = new \Lib\CalBuilder($this->events);
        $newCal->write($filename);
    }

}