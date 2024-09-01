<?php

namespace Mindgoner\LaravelOrlenPaczka\Requests;

use Mindgoner\LaravelOrlenPaczka\Connection\OrlenPaczkaConnector;

use Illuminate\Support\Facades\Log;

use Mindgoner\LaravelOrlenPaczka\Models\OPAuth;
use Mindgoner\LaravelOrlenPaczka\Models\OPPack;

class LabelPrintDuplicate extends OrlenPaczkaConnector
{
    private $OPPack;
    private $Auth;
    public $Response;

    /**
     * Validation data
     * 
     * @var array
     */
    private $validator = [
        'OPPack' => 'required',
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
    public function __construct(OPPack $OPPack){
        $this->Auth = new OPAuth();
        $this->OPPack = $OPPack;
    }
    
    public function get(){
        $this->setWsdlSuffix('/LabelPrintDuplicate');
        return $this->sendRequest('GET', $this->constructAttributes());
    }

    /**
     * Construct attributes
     * 
     * @return array
     */
    public function constructAttributes(){
        $attributes = array_merge(
            $this->Auth->toArray(),
            ['PackCode' => $this->OPPack->PackCode]
        );
        return $attributes;
    }

    /**
     * Get label in base64
     * 
     * @return string
     */
    public function base64(){
        try{
            $xml = new \SimpleXMLElement($this->response);
            $PackCode = (string) $xml->Label;
            if($PackCode == ''){
                throw new \Exception('Label not found in response');
            }
            return $PackCode;
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }

    /**
     * Get label in PDF
     * 
     * @return binary
     */
    public function pdf(){
        return base64_decode($this->base64());
    }

}