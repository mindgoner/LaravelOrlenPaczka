<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPSender extends OPModel {

    public $SenderEMail;
    public $SenderFirstName;
    public $SenderLastName;
    public $SenderCompanyName;
    public $SenderStreetName;
    public $SenderBuildingNumber;
    public $SenderFlatNumber;
    public $SenderCity;
    public $SenderPostCode;
    public $SenderPhoneNumber;
    public $SenderOrders;

    public $validator = [
        'SenderEMail' => 'required|email',
        'SenderFirstName' => 'required',
        'SenderLastName' => 'required',
        'SenderCompanyName' => 'nullable',
        'SenderStreetName' => 'required',
        'SenderBuildingNumber' => 'required',
        'SenderFlatNumber' => 'nullable',
        'SenderCity' => 'required',
        'SenderPostCode' => 'required',
        'SenderPhoneNumber' => 'required',
        'SenderOrders' => 'nullable',
    ];

    public function __construct($params = []){
        parent::__construct($params);
    }
}
