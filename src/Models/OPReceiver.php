<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPReceiver extends OPModel{
    
    public $EMail;
    public $FirstName;
    public $LastName;
    public $CompanyName;
    public $StreetName;
    public $BuildingNumber;
    public $FlatNumber;
    public $City;
    public $PostCode;
    public $PhoneNumber;

    private $validator = [
        'EMail' => 'required|email',
        'FirstName' => 'required',
        'LastName' => 'required',
        'CompanyName' => 'nullable',
        'StreetName' => 'required',
        'BuildingNumber' => 'required',
        'FlatNumber' => 'required',
        'City' => 'required',
        'PostCode' => 'required',
        'PhoneNumber' => 'required',
    ];

    public function __construct($params = []){
        parent::__construct($params);
    }

}