<?php

namespace Mindgoner\LaravelOrlenPaczka\Requests;

use Mindgoner\LaravelOrlenPaczka\Connection\OrlenPaczkaConnector;

use Mindgoner\LaravelOrlenPaczka\Models\OPAuth;
use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;
use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;
use Mindgoner\LaravelOrlenPaczka\Models\OPSender;
use Mindgoner\LaravelOrlenPaczka\Models\OPPack;

class CallPickup extends OrlenPaczkaConnector
{

    public $packList = [];
    public $readyDate;
    public $pickupDate;

    private $validator = [
        'packList' => 'required|array',
        'packList.*' => 'min:1',
        'readyDate' => 'required|date|after:today',
        'pickupDate' => 'required|date|after:readyDate',
    ];

    public function __construct($params = []) {

        // Request require Auth, so we need to create Auth object:
        $this->Auth = new OPAuth();

        // By default set readyDate and pickupDate to current date (or tommorow if current time is after 11:00) and 13:00:
        if (!isset($params['readyDate'])) {
            // If after 16:00, set readyDate to tommorow::
            if(date('H') >= 7){
                $this->readyDate = date('Y-m-d\T07:00:00P', strtotime('+1 day'));
            }else{
                $this->readyDate = date('Y-m-d\T07:00:00P');
            }
        }
        if (!isset($params['pickupDate'])) {
            // If after 16:00, set pickupDate to tommorow::
            if(date('H') >= 7){
                $this->pickupDate = date('Y-m-d\T16:00:00P', strtotime('+1 day'));
            }else{
                $this->pickupDate = date('Y-m-d\T16:00:00P');
            }
        }

        // Check if packList is set and is list of OPPack objects:
        if(isset($params['packList'])){
            foreach($params['packList'] as $pack){

                // Check if element is type of OPPack:
                if(!is_a($pack, OPPack::class)){
                    throw new \InvalidArgumentException('packList must contain only OPPack objects');
                }

                // Add pack to packList:
                $this->packList[] = $pack;

            }
        }
    }
    
    /**
     * Convert object to XML
     * 
     * @return string
     */
    public function toXMLString(){
        $packsAsStrings = '';
        foreach($this->packList as $PackObject){
            $packAsXML = $PackObject->toXMLString();
            
            // CallPickup method needs <PackCode> tag be replaced with <string>. Replace all:
            $packAsString = str_replace(
                ['<PackCode>', '</PackCode>'],  // Otwierający i zamykający znacznik
                ['<string>', '</string>'],      // Nowe otwierające i zamykające znaczniki
                $packAsXML
            );

            $packsAsStrings .= $packAsString;
        }

        $xmlString = [
            '<partnerId>'.$this->Auth->PartnerID.'</partnerId>',
            '<partnerKey>'.$this->Auth->PartnerKey.'</partnerKey>',
            '<packList>'.$packsAsStrings.'</packList>',
            '<readyDate>'.$this->readyDate.'</readyDate>',
            '<pickupDate>'.$this->pickupDate.'</pickupDate>',
        ];

        $xmlString = implode('', $xmlString);
    
        return '<CallPickup xmlns="'.$this->getXmlns().'">'.$xmlString.'</CallPickup>';
    }
    

    public function send(){
        $body = $this->toXMLString();
        return $this->sendXMLRequest('POST', $body);
    }
}