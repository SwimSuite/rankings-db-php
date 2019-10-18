<?php

namespace RankingsDB;

class Event
{
    protected $_stroke;
    protected $_distance;

    public function __construct($stroke, $distance)
    {
        $this->_stroke = $stroke;
        $this->_distance = $distance;
    }

    /**
     * @return Stroke
     */
    public function stroke()
    {
        return $this->_stroke;
    }

    /**
     * @return int
     */
    public function distance()
    {
        return $this->_distance;
    }

    public function eventID(){
        return $this->_stroke . $this->_distance;
    }

    public static function fromEventID($event_id){
        $stroke = substr($event_id, 0, 2);
        $distance = intval(substr($event_id, 2));
        return new Event($stroke, $distance);
    }

}