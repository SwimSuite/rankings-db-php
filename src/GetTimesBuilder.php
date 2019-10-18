<?php

namespace RankingsDB;

use Cassandra\Date;
use DateTime;

class GetTimesBuilder
{
    protected $_member_id;
    protected $_from_date = null;
    protected $_to_date = null;
    protected $_course = "S";
    protected $_level = 0;
    protected $_include_masters = true;
    protected $_include_relays = false;

    public function __construct($member_id)
    {
        $this->_member_id = $member_id;
    }

    /**
     * @param null $from_date
     * @return GetTimesBuilder
     */
    public function setFromDate($from_date)
    {
        $this->_from_date = $from_date;
        return $this;
    }

    /**
     * @param null $to_date
     * @return GetTimesBuilder
     */
    public function setToDate($to_date)
    {
        $this->_to_date = $to_date;
        return $this;
    }

    /**
     * @param string $course
     * @return GetTimesBuilder
     */
    public function setCourse($course)
    {
        $this->_course = $course;
        return $this;
    }

    /**
     * @param int $level
     * @return GetTimesBuilder
     */
    public function setLevel($level)
    {
        $this->_level = $level;
        return $this;
    }

    /**
     * @param bool $include_masters
     * @return GetTimesBuilder
     */
    public function setIncludeMasters($include_masters)
    {
        $this->_include_masters = $include_masters;
        return $this;
    }

    /**
     * @param bool $include_relays
     * @return GetTimesBuilder
     */
    public function setIncludeRelays($include_relays)
    {
        $this->_include_relays = $include_relays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberID()
    {
        return $this->_member_id;
    }

    /**
     * @return DateTime
     */
    public function getFromDate()
    {
        if ($this->_from_date === null){
            return (new DateTime("1970-01-01"))->setTime(0, 0, 0);
        }
        return $this->_from_date;
    }

    /**
     * @return DateTime
     */
    public function getToDate()
    {
        if ($this->_to_date === null){
            return (new DateTime());
        }
        return $this->_to_date;
    }

    /**
     * @return string
     */
    public function getCourse()
    {
        return $this->_course;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @return bool
     */
    public function includeMasters()
    {
        return $this->_include_masters;
    }

    /**
     * @return bool
     */
    public function includeRelays()
    {
        return $this->_include_relays;
    }

}