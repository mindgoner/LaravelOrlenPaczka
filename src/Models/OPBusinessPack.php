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
    public $PrintAddress;
    public $PrintType;
    public $TransferDescription;

    private $validator = [
        'DestinationCode' => 'required',
        'AlternativeDestinationCode' => 'nullable',
        'ReturnDestinationCode' => 'nullable',
        'BoxSize' => 'required',
        'PackValue' => 'required|numeric',
        'CashOnDelivery' => 'required|boolean',
        'AmountCashOnDelivery' => 'nullable|numeric',
        'Insurance' => 'nullable|boolean',
        'PrintAddress' => 'required',
        'PrintType' => 'required',
        'TransferDescription' => 'nullable',
    ];

    public function __construct($params = []) {
        parent::__construct($params);
    }
    
}
