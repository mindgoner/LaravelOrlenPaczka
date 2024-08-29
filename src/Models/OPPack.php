<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPPack extends OPModel {

    public $PackCode;

    private $validator = [
        'PackCode' => 'required',
    ];

    public function __construct($params = []) {
        parent::__construct($params);
    }
    
}
