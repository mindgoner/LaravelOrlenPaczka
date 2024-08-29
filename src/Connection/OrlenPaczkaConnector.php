<?php

namespace Mindgoner\LaravelOrlenPaczka\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Mindgoner\LaravelOrlenPaczka\Models\OPAuth;

class OrlenPaczkaConnector{

    private $client;
    private $wsdl = 'https://api.orlenpaczka.pl/WebServicePwRProd/WebServicePwR.asmx';
    private $xmlns = 'https://91.242.220.103/WebServicePwR';
    private $SOAPAction = 'https://91.242.220.103/WebServicePwR/[METHOD_NAME]';
    private $Auth;
    private $authRequired = false;
    private $wsdlSuffix = '';
    public $response = null;

    public function __construct($params = []) {
        $this->Auth = new OPAuth();
    }

    /**
     * Wrap XML body in SOAP envelope
     * 
     * @param string $body
     * @return string
     */
    public function envelope($body){
        $envelope = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                '.$body.'
            </soap:Body>
        </soap:Envelope>';
        return $envelope;
    }

    /**
     * Send request to OrlenPaczka API
     * 
     * @param string $method 'POST' or 'GET'
     * @param string $xmlBody
     * @return string $response
     * @throws \InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendXMLRequest($method, $xmlBody){
        if (!is_string($xmlBody)) {
            throw new \InvalidArgumentException('Expected $xmlBody to be a string, ' . gettype($xmlBody) . ' given.');
        }
    
        $contentLength = strlen($xmlBody);
        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8',
            'Content-Length' => $contentLength,
            'SOAPAction' => str_replace('[METHOD_NAME]', class_basename($this), $this->SOAPAction)
        ];
    
        $this->client = new Client([
            'base_uri' => $this->wsdl.$this->wsdlSuffix,
        ]);
    
        try {
            if(is_null($this->Auth)){
                $this->Auth = new OPAuth();
            }
            $authQuery = http_build_query([
                'PartnerID' => $this->Auth->PartnerID,
                'PartnerKey' => $this->Auth->PartnerKey
            ]);
            if($method === 'POST'){
                $response = $this->client->post($this->wsdl.$this->wsdlSuffix, [
                    'headers' => $headers,
                    'body' => $this->envelope($xmlBody),
                    'query' => $authQuery
                ]);
            } else {
                $response = $this->client->get($this->wsdl.$this->wsdlSuffix, [
                    'headers' => $headers,
                    'query' => $this->envelope($xmlBody) // Zamiast 'body', użyj 'query' w GET
                ]);
            }
            $this->response = $response->getBody()->getContents();
            return $this->response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->response = null;
            return 'Request failed: ' . $e->getMessage();
        } catch (\Exception $e) {
            $this->response = null;
            return 'An error occurred: ' . $e->getMessage();
        }
    }

    /**
     * Get xmlns
     * 
     * @return string
     */
    public function getXmlns(){
        return $this->xmlns;
    }

    /**
     * Send request to OrlenPaczka API
     * 
     * @param string $method 'POST' or 'GET'
     * @param string $HttpBuilder
     * @return string $response
     * @throws \InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest($method, $additionalParams = []){
        if(is_null($this->Auth)){
            $this->Auth = new OPAuth();
        }

        $params = [];

        $AuthParams = [
            'PartnerID' => $this->Auth->PartnerID,
            'PartnerKey' => $this->Auth->PartnerKey
        ];

        $params = array_merge($AuthParams, $additionalParams);

        // Prepare body:
        $HttpBuilder = http_build_query($params);


        // Prepare client:
        $this->client = new Client([
            'base_uri' => $this->wsdl.$this->wsdlSuffix,
            'headers'  => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        // Send request:
        $response = $this->client->get('?' . $HttpBuilder);
        $body = $response->getBody();

        $this->response = $response->getBody()->getContents();
        return $this->response;
    }

    /**
     * Check if response is successful
     * 
     * @return bool
     * @throws \Exception
     */
    public function success(){
        if(!is_null($this->response)){
            try{
                $xml = new \SimpleXMLElement($this->response);
                if($xml){
                    return true;
                }
            }catch(\Exception $e){
                return false;
            }
        }
        return false;
    }


    /**
     * Set wsdl suffix
     * 
     * @param string $suffix
     * @return void
     */
    public function setWsdlSuffix($suffix){
        $this->wsdlSuffix = $suffix;
    }

    /**
     * Clear wsdl suffix
     * 
     * @return void
     */
    public function clearWsdlSuffix(){
        $this->wsdlSuffix = '';
    }
}