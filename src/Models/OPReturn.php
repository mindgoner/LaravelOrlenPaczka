<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPReturn extends OPModel {

    public $ReturnDestinationCode;
    public $ReturnEMail;
    public $ReturnFirstName;
    public $ReturnLastName;
    public $ReturnCompanyName;
    public $ReturnStreetName;
    public $ReturnBuildingNumber;
    public $ReturnFlatNumber;
    public $ReturnCity;
    public $ReturnPostCode;
    public $ReturnPhoneNumber;
    public $ReturnPack;
    public $ReturnAvailable = false;
    public $ReturnQuantity = 0;

    private $validator = [
        'ReturnDestinationCode' => 'required',
        'ReturnEMail' => 'required|email',
        'ReturnFirstName' => 'required',
        'ReturnLastName' => 'required',
        'ReturnCompanyName' => 'nullable',
        'ReturnStreetName' => 'required',
        'ReturnBuildingNumber' => 'required',
        'ReturnFlatNumber' => 'nullable', // Możliwe, że jest opcjonalne
        'ReturnCity' => 'required',
        'ReturnPostCode' => 'required',
        'ReturnPhoneNumber' => 'required',
        'ReturnPack' => 'required',
        'ReturnAvailable' => 'required|boolean',
        'ReturnQuantity' => 'required|numeric',
    ];

    public function __construct($params = []){
        parent::__construct($params);
    }

}
