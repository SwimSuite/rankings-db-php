<?php

namespace RankingsDB;

use DateTime;

class MemberDetails
{
    protected $_memberID;
    protected $_firstName;
    protected $_lastName;
    protected $_DoB;
    protected $_sex;
    protected $_knownAs;
    protected $_initials;
    protected $_iClass;
    protected $_clubs;
    protected $_country;
    protected $_countryCode;
    protected $_lapsed;
    protected $_S_CLASS;
    protected $_SM_CLASS;
    protected $_SB_CLASS;
    protected $_IPC_CODES;

    public function __construct($member_details)
    {
        $this->_memberID = $member_details->MemberID;
        $this->_firstName = $member_details->FirstName;
        $this->_lastName = $member_details->LastName;
        $this->_DoB = DateTime::createFromFormat("Y-m-d", $member_details->DateOfBirth)->setTime(0, 0, 0);
        $this->_sex = $member_details->Sex;
        $this->_knownAs = $member_details->KnownAs;
        $this->_initials = $member_details->Initials;
        $this->_iClass = $member_details->IClass;
        $this->_country = $member_details->Country;
        $this->_countryCode = $member_details->CountryCode;
        $this->_lapsed = $member_details->Lapsed;
        $this->_S_CLASS = $member_details->S_CLASS;
        $this->_SM_CLASS = $member_details->SM_CLASS;
        $this->_SB_CLASS = $member_details->SB_CLASS;
        $this->_IPC_CODES = $member_details->IPC_CODES;
        $this->_clubs = [];

        for ($i = 1; $i <= 5; $i++) {
            $club = "Club" . $i;
            $clubstr = $member_details->$club;
            if ($clubstr == "") {
                continue;
            }
            $ranked = $member_details->Ranked == $clubstr;
            $this->_clubs[] = new Club($clubstr, $ranked);
        }

    }

    /**
     * @return int
     */
    public function MemberID()
    {
        return $this->_memberID;
    }

    /**
     * @return string
     */
    public function FirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return string
     */
    public function LastName()
    {
        return $this->_lastName;
    }

    /**
     * @return string
     */
    public function KnownAs()
    {
        return $this->_knownAs;
    }

    /**
     * @return string
     */
    public function Initials()
    {
        return $this->_initials;
    }

    /**
     * @return Club[]
     */
    public function Clubs()
    {
        return $this->_clubs;
    }

    /**
     * @return DateTime
     */
    public function DateOfBirth()
    {
        return $this->_DoB;
    }

    /**
     * @return Sex
     */
    public function Sex()
    {
        return $this->_sex;
    }

    /**
     * @return mixed
     */
    public function CountryCode()
    {
        return $this->_countryCode;
    }

    /**
     * @return string
     */
    public function Country()
    {
        return $this->_country;
    }


    /**
     * @return mixed
     */
    public function IPCCodes()
    {
        return $this->_IPC_CODES;
    }

    /**
     * @return int|null
     */
    public function SBClass()
    {
        if ($this->_SB_CLASS == 0) return null;
        return $this->_SB_CLASS;
    }

    /**
     * @return int|null
     */
    public function SMClass()
    {
        if ($this->_SM_CLASS == 0) return null;
        return $this->_SM_CLASS;
    }

    /**
     * @return int|null
     */
    public function SClass()
    {
        if ($this->_S_CLASS == 0) return null;
        return $this->_S_CLASS;
    }

    /**
     * @return mixed
     */
    public function getIClass()
    {
        return $this->_iClass;
    }

    /**
     * @return boolean
     */
    public function Lapsed()
    {
        return $this->_lapsed;
    }
}