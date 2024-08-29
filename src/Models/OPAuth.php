<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

class OPAuth extends OPModel{

    public $PartnerID;
    public $PartnerKey;

    public $validator = [
        'PartnerID' => 'required',
        'PartnerKey' => 'required',
    ];

    /**
     * Constructor
     * 
     * @param string $partnerKey
     * @param string $partnerId
     */
    public function __construct($attributes = []){

        // Init params:
        $this->PartnerID = isset($attributes['PartnerID']) ? $attributes['PartnerID'] : config('orlenpaczka.PartnerID', '');
        $this->PartnerKey = isset($attributes['PartnerKey']) ? $attributes['PartnerKey'] : config('orlenpaczka.PartnerKey', '');

        $this->checkAuthParams();

    }

    /**
     * Check if PartnerID and PartnerKey are set
     * 
     * @return void
     * @throws \InvalidArgumentException
     */
    private function checkAuthParams()
    {
        if($this->PartnerID == '' || $this->PartnerKey == ''){             
            throw new \InvalidArgumentException('PartnerID and PartnerKey are required');
        }
        if($this->PartnerID == 'default-partner-id' || $this->PartnerKey == 'default-partner-key') {
            throw new \InvalidArgumentException('OP_PARTNERKEY and/or OP_PARTNERID are not set in .env file.');
        }
        if(strlen($this->PartnerID) != 10 || strlen($this->PartnerKey) != 10){
            throw new \InvalidArgumentException('PartnerID and/or PartnerKey are invalid.');
        }
    }

}
