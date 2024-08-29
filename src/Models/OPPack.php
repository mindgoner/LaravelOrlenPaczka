<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPPack extends OPModel {

    public $PackCode;

    public $validator = [
        'PackCode' => 'required',
    ];

    public function __construct($params = []) {
        parent::__construct($params);
    }
    
}
