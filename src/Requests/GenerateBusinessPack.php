<?php

namespace Mindgoner\LaravelOrlenPaczka\Requests;

use Mindgoner\LaravelOrlenPaczka\Connection\OrlenPaczkaConnector;

use Mindgoner\LaravelOrlenPaczka\Models\OPAuth;
use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;
use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;
use Mindgoner\LaravelOrlenPaczka\Models\OPSender;

class GenerateBusinessPack extends OrlenPaczkaConnector
{
    public $Sender;
    public $Receiver;
    public $Return;
    public $BusinessPack;
    private $Auth;

    /**
     * Validation data
     * 
     * @var array
     */
    private $validator = [
        'Sender' => 'required',
        'Receiver' => 'required',
        'Return' => 'required',
        'BusinessPack' => 'required',
    ];

    /**
     * Constructor method
     * 
     * @param OPSender $OPSender
     * @param OPBusinessPack $OPBusinessPack
     * @param OPReturn $OPReturn
     * @param OPReceiver $OPReceiver
     * 
     * @return void
     */
    public function __construct(OPSender $OPSender, OPBusinessPack $OPBusinessPack, OPReturn $OPReturn, OPReceiver $OPReceiver){
        $this->Auth = new OPAuth();
        $this->Sender = $OPSender;
        $this->Receiver = $OPReceiver;
        $this->Return = $OPReturn;
        $this->BusinessPack = $OPBusinessPack;
    }

    /**
     * Convert object to XML
     * 
     * @return string
     */
    public function toXMLString(){
        $xmlString = [
            $this->Auth->toXMLString(),
            $this->Sender->toXMLString(),
            $this->Receiver->toXMLString(),
            $this->Return->toXMLString(),
            $this->BusinessPack->toXMLString(),
        ];

        $xmlString = implode('', $xmlString);
    
        return '<BusinessPack xmlns="'.$this->getXmlns().'">'.$xmlString.'</BusinessPack>';
    }
    

    public function send(){
        $body = $this->toXMLString();
        return $this->sendRequest('POST', $body);
    }
}