<?php

namespace Mindgoner\LaravelOrlenPaczka\Requests;

use Mindgoner\LaravelOrlenPaczka\Connection\OrlenPaczkaConnector;

use Mindgoner\LaravelOrlenPaczka\Models\OPAuth;
use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;
use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;
use Mindgoner\LaravelOrlenPaczka\Models\OPSender;

class GiveMeAllLocationWithAllData extends OrlenPaczkaConnector
{
    public $LocationsList = [];

    public function get(){
        $this->setWsdlSuffix('/GiveMeAllLocationWithAllData');
        return $this->convertToArray($this->sendRequest('GET'));
    }

    public function convertToArray($request){
        $xml = simplexml_load_string($request);
        $namespaces = $xml->getNamespaces(true);
        $dataSet = $xml->children($namespaces['diffgr'])->diffgram->children()->NewDataSet; // 
        return $dataSet;
    }

}