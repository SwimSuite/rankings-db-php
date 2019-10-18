<?php

namespace RankingsDB;

class Time
{
    protected $_event;
    protected $_minutes = 0;
    protected $_seconds = 0;
    protected $_hundredths = 0;

    /**
     * Time constructor.
     *
     * @param $event Event
     * @param $time_str string
     */
    public function __construct($event, $time_str)
    {
        $this->_event = $event;
        $this->_hundredths = intval(substr($time_str, strlen($time_str) - 2, 2));
        $this->_seconds = intval(substr($time_str, strlen($time_str) - 4, 2));
        $this->_minutes = intval(substr($time_str, 0, strlen($time_str) - 4));
    }

    /**
     * @return Stroke
     */
    public function stroke()
    {
        return $this->_event->stroke();
    }

    /**
     * @return int
     */
    public function distance()
    {
        return $this->_event->distance();
    }

    /**
     * @return Event
     */
    public function event()
    {
        return $this->_event;
    }

    public function getTime($leading_zeroes = true)
    {
        $time = sprintf("%02d.%02d", $this->_seconds, $this->_hundredths);
        if ($this->_minutes !== 0 || $leading_zeroes) {
            $time = $this->_minutes . ":" . $time;
        }
        return $time;
    }

    public function getTimeInSeconds()
    {
        return $this->_seconds * 60 + $this->_seconds + $this->_hundredths / 100;
    }

    public function __toString()
    {
        return $this->_event->eventID() . ": " . $this->getTime();
    }


}