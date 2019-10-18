<?php


namespace RankingsDB;


use DateTime;
use SoapVar;
use TypeError as TypError;

class RankingsClient
{
    public $_soap_client;
    protected $_personal_key;
    protected $_personal_key_member_number;
    private static $_user = "6719218280CF981A54BFE34E37074B7F";
    private static $_pass = "2633963A462E2831B6D5F424B195D2DB";
    private $_soap_user;
    private $_soap_pass;
    private $_soap_pk;
    private $_soap_pk_id;

    protected $wsdl = true;

    /***
     * Construct a RankingsDB Client
     *
     * Personal key should be fetched from www.swimmingresults.org.
     * The Membership Number is the membership number for the user that requested the personal key.
     *
     * E.g.: If it is your personal key, then membership number is your membership number.
     *
     * @param $personal_key string Personal Key
     * @param $membership_number int Membership Number
     *
     * @throws TypError Raises a type error if an invalid type is passed
     */
    public function __construct($personal_key, $membership_number)
    {
        $this->_soap_user = new SoapVar(RankingsClient::$_user, XSD_STRING);
        $this->_soap_pass = new SoapVar(RankingsClient::$_pass, XSD_STRING);

        if (!is_int($membership_number)) {
            throw new TypError("Personal key number must be an integer");
        }

        $this->_personal_key = $personal_key;
        $this->_personal_key_member_number = $membership_number;

        $this->_soap_pk = new SoapVar($this->_personal_key, XSD_STRING);
        $this->_soap_pk_id = new SoapVar($this->_personal_key_member_number, XSD_INT);

        try {
//            $this->_soap_client = new nusoap_client("https://www.swimmingresults.org/soap/BritSwimWebServ.php?wsdl", "wsdl");
//            $this->_soap_client->soap_defencoding = 'UTF-8';
//            $this->_soap_client->decode_utf8 = FALSE;
//            $this->_soap_client->setUseCURL(true);
//            $this->_soap_client->setCurlOption(CURLOPT_USERAGENT, $this->get_user_agent());
//            $this->_soap_client->loadWSDL();
//            $err = $this->_soap_client->getError();
            ini_set("soap.wsdl_cache_ttl", 0);
            $this->_soap_client = new SoapClient(
                null,
                [
                    "location" =>"https://www.swimmingresults.org/soap/BritSwimWebServ.php",
                    "uri" =>"https://www.swimmingresults.org/soap",
                    "trace" => 1
                ]
            );
            $this->_soap_client->wsdl = false;

            $this->wsdl = false;
//            if($err){
//                print($err);
//            }
        } catch (\SoapFault $fault) {
            print($fault);
        }
    }

    protected function get_user_agent()
    {
        if ($this->wsdl) {
            return "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
        }
        return "SOAP Toolkit 3.0";
    }

    /**
     * Fetches a member's details from their ID number
     *
     * @param $member_id
     *
     * @return MemberDetails
     *
     * @throws MemberNotFound
     */
    public function getMemberDetails($member_id)
    {
        if (!is_int($member_id)) {
            throw new TypError("Personal key number must be an integer");
        }
        $soap_member_id = new SoapVar($member_id, XSD_INT);
        $member = $this->_soap_client->MembDetailsSingleMembV2(
            $this->_soap_user,
            $this->_soap_pass,
            $soap_member_id,
            $this->_soap_pk,
            $this->_soap_pk_id
        );
        return new MemberDetails($member[0]);
    }

    //MembTimeAllEventsV3(ClientUser: xsd:string, ClientPass: xsd:string, MemberID: xsd:int, SwimFromDate: xsd:string, SwimToDate: xsd:string, Course: xsd:string, EntryLevel: xsd:int, MastersSwims: xsd:boolean, RelaySplitsSwims: xsd:boolean)

    /**
     * @param $options GetTimesBuilder
     *
     * @return Times
     */
    public function getTimes($options)
    {
        $soap_member_id = new SoapVar($options->getMemberID(), XSD_INT);
        $times = $this->_soap_client->MembTimeAllEventsV3(
            $this->_soap_user,
            $this->_soap_pass,
            $soap_member_id,
            new SoapVar($options->getFromDate()->format("Y-m-d"), XSD_STRING),
            new SoapVar($options->getToDate()->format("Y-m-d"), XSD_STRING),
            new SoapVar($options->getCourse(), XSD_STRING),
            new SoapVar($options->getLevel(), XSD_INT),
            new SoapVar($options->includeMasters(), XSD_BOOLEAN),
            new SoapVar($options->includeRelays(), XSD_BOOLEAN)
        );
        return new Times($times);
    }

}