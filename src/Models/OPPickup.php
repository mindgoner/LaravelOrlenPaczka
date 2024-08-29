<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPPickup extends OPModel {

    public $packList;
    public $readyDate;
    public $pickupDate;

    private $validator = [
        'packList' => 'required|array',
        'packList.*' => 'min:1',
        'readyDate' => 'required',
        'pickupDate' => 'required',
    ];

    public function __construct($params = []) {
        parent::__construct($params);

        // By default set readyDate to current date and pickupDate to 7 days from now:
        if (!isset($this->readyDate)) {
            $this->readyDate = date('Y-m-d');
        }
        if (!isset($this->pickupDate)) {
            $this->pickupDate = date('Y-m-d', strtotime('+7 days'));
        }
    }
    
}
