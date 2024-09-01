<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPBusinessPack extends OPModel {

    public $AlternativeDestinationCode;
    public $BoxSize;
    public $PackValue;
    public $CashOnDelivery;
    public $AmountCashOnDelivery;
    public $Insurance;
    public $PrintAdress;
    public $PrintType;
    public $TransferDescription;

    public $validator = [
        'AlternativeDestinationCode' => 'nullable',
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
