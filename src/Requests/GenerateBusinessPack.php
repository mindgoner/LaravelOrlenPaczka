<?php

namespace Mindgoner\LaravelOrlenPaczka\Requests;

use Mindgoner\LaravelOrlenPaczka\Connection\OrlenPaczkaConnector;

use Illuminate\Support\Facades\Log;

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
    /*
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
    */
    

    public function send(){
        $this->setWsdlSuffix('/GenerateBusinessPack');
        $data = array_merge(
            $this->Auth->toArray(),
            $this->Sender->toArray(),
            $this->Receiver->toArray(),
            $this->Return->toArray(),
            $this->BusinessPack->toArray(),
        );
        $this->response = $this->sendRequest('GET', $data);
        return $this->response;
    }

    /**
     * Get PackCode from response
     * 
     * @return string
     * @throws \Exception
     */
    public function getPackCode(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $PackCode = (string) $xml->xpath('//GenerateBusinessPack/PackCode_RUCH')[0];
            if($PackCode == ''){
                throw new \Exception('PackCode not found in response');
            }
            return $PackCode;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            Log::info($this->response);
            return false;
        }
    }

    /**
     * Get DestinationCode from response
     * 
     * @return string
     * @throws \Exception
     */
    public function getDestinationCode(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $destinationCode = (string) $xml->xpath('//GenerateBusinessPack/DestinationCode')[0];
            if($destinationCode == ''){
                throw new \Exception('DestinationCode not found in response');
            }
            return $destinationCode;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            Log::info($this->response);
            return false;
        }
    }

    /**
     * Get DestinationId from response
     * 
     * @return string
     * @throws \Exception
     */
    public function getDestinationId(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $destinationId = (string) $xml->xpath('//GenerateBusinessPack/DestinationId')[0];
            if($destinationId == ''){
                throw new \Exception('DestinationId not found in response');
            }
            return $destinationId;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            Log::info($this->response);
            return false;
        }
    }

    /**
     * Get PackPrice from response
     * 
     * @return string
     * @throws \Exception
     */
    public function getPackPrice(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $packPrice = (string) $xml->xpath('//GenerateBusinessPack/PackPrice')[0];
            if($packPrice == ''){
                throw new \Exception('PackPrice not found in response');
            }
            return $packPrice;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            Log::info($this->response);
            return false;
        }
    }

    /**
     * Get PackPaid from response
     * 
     * @return string
     * @throws \Exception
     */
    public function getPackPaid(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $packPaid = (string) $xml->xpath('//GenerateBusinessPack/PackPaid')[0];
            if($packPaid == ''){
                throw new \Exception('PackPaid not found in response');
            }
            return $packPaid;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            Log::info($this->response);
            return false;
        }
    }
}