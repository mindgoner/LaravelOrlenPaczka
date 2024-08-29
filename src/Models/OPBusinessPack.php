<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPBusinessPack extends OPModel {

    public $DestinationCode;
    public $AlternativeDestinationCode;
    public $ReturnDestinationCode;
    public $BoxSize;
    public $PackValue;
    public $CashOnDelivery;
    public $AmountCashOnDelivery;
    public $Insurance;
    public $PrintAdress;
    public $PrintType;
    public $TransferDescription;

    public $validator = [
        'DestinationCode' => 'required',
        'AlternativeDestinationCode' => 'nullable',
        'ReturnDestinationCode' => 'nullable',
        'BoxSize' => 'required',
        'PackValue' => 'required|numeric',
        'CashOnDelivery' => 'required|boolean',
        'AmountCashOnDelivery' => 'nullable|numeric',
        'Insurance' => 'nullable|numeric',
        'PrintAdress' => 'required',
        'PrintType' => 'required',
        'TransferDescription' => 'nullable',
    ];

    public function __construct($params = []) {
        parent::__construct($params);
    }
    
}
