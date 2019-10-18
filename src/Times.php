<?php

namespace RankingsDB;

class Times implements \Iterator
{
    static protected $_event_map = [
        1 => Stroke::FREESTYLE . "50",
        2 => Stroke::FREESTYLE . "100",
        3 => Stroke::FREESTYLE . "200",
        4 => Stroke::FREESTYLE . "400",
        5 => Stroke::FREESTYLE . "800",
        6 => Stroke::FREESTYLE . "1500",
        7 => Stroke::BREASTSTROKE . "50",
        8 => Stroke::BREASTSTROKE . "100",
        9 => Stroke::BREASTSTROKE . "200",
        10 => Stroke::BUTTERFLY . "50",
        11 => Stroke::BUTTERFLY . "100",
        12 => Stroke::BUTTERFLY . "200",
        13 => Stroke::BACKSTROKE . "50",
        14 => Stroke::BACKSTROKE . "100",
        15 => Stroke::BACKSTROKE . "200",
        16 => Stroke::INDIVIDUAL_MEDLEY . "100",
        17 => Stroke::INDIVIDUAL_MEDLEY . "200",
        18 => Stroke::INDIVIDUAL_MEDLEY . "400"
    ];
    protected $_times = [];
    protected $_pointer = 0;

    public function __construct($times)
    {
        foreach ($times as $time) {
            $event_id = Times::$_event_map[$time->Event];
            $event = Event::fromEventID($event_id);
            $this->_times[$event_id] = new Time($event, $time->Time);
        }
    }

    static protected function _evtKey($distance, $stroke)
    {
        return (new Event($stroke, $distance))->eventID();
    }

    public function getTime($distance, $stroke)
    {
        return $this->_times[$this->_evtKey($distance, $stroke)];
    }

    protected function _getKeyAtPos($position){
        $keys = array_keys($this->_times);
        return $keys[$position];
    }

    protected function _getTimeAtPos($position){
        return $this->_times[$this->_getKeyAtPos($position)];
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->_getTimeAtPos($this->_pointer);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->_pointer;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return string|float|int|bool|null scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->_getKeyAtPos($this->_pointer);
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
        return $this->_pointer < count($this->_times);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->_pointer = 0;
    }
}