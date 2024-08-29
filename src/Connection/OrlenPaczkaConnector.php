<?php

namespace Mindgoner\LaravelOrlenPaczka\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OrlenPaczkaConnector{

    private $partnerKey;
    private $partnerId;
    private $client;
    private $wsdl = 'https://api.orlenpaczka.pl/WebServicePwRProd/WebServicePwR.asmx';
    private $xmlns = 'https://91.242.220.103/WebServicePwR';
    private $SOAPAction = 'https://91.242.220.103/WebServicePwR/[METHOD_NAME]';
    private $authRequired = false;

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
            'base_uri' => $this->wsdl,
        ]);
    
        try {
            $authQuery = http_build_query([
                'PartnerID' => $this->partnerId,
                'PartnerKey' => $this->partnerKey
            ]);
            if($method === 'POST'){
                $response = $this->client->post($this->wsdl, [
                    'headers' => $headers,
                    'body' => $this->envelope($xmlBody),
                    'query' => $authQuery
                ]);
            } else {
                $response = $this->client->get($this->wsdl, [
                    'headers' => $headers,
                    'query' => $this->envelope($xmlBody) // Zamiast 'body', użyj 'query' w GET
                ]);
            }
    
            return $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return 'Request failed: ' . $e->getMessage();
        } catch (\Exception $e) {
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

}