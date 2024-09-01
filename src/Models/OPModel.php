<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OPModel{

    /**
     * Create a new model instance
     * 
     * @param array $params
     * 
     * @return void
     */
    public function __construct($params = []){
        if(is_array($params)){
            foreach($params as $key => $value){
                $this->$key = $value;
            }
        }
        $this->validate();
    }

    /**
     * Validate the model
     * 
     * @return ValidationException errors
     */
    public function validate(){
        $validator = Validator::make($this->toArray(), $this->validator);
        if($validator->fails()){
            return $validator->errors();
        }
    }

    /**
     * Convert the model to XML
     * 
     * @param bool $wrapClassName
     * 
     * @return string
     */
    public function toXMLString($wrapClassName = false) {
        // Turn the object into an XML string:
        $Object = new \stdClass();
        foreach($this as $key => $value) {
            $Object->$key = $value;
        }
    
        // Determine the root element name based on wrapClassName
        if ($wrapClassName) {
            $xml = new \SimpleXMLElement('<OPReceiver/>');
        } else {
            $xml = new \SimpleXMLElement('<root/>'); // Temporary root
        }
    
        $this->addChildren($xml, $Object);
    
        // If not wrapping with OPReceiver, return inner XML content only
        if (!$wrapClassName) {
            // Get the inner XML content by removing the temporary root
            $innerXml = '';
            foreach ($xml->children() as $child) {
                $innerXml .= $child->asXML();
            }
            return $innerXml;
        }
    
        return $xml->asXML();
    }
    
    
    /**
     * Helper function to add children to XML (helper of 'toXMLString()' method)
     * 
     * @param SimpleXMLElement $xml
     * @param array $data
     * 
     * @return void
     */
    private function addChildren($xml, $data) {
        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $subnode = $xml->addChild($key);
                $this->addChildren($subnode, $value);
            } else {
                if (!empty($key)) {
                    $xml->addChild($key, htmlspecialchars($value));
                }
            }
        }
    }

    /**
     * Convert the model variables into dictionary
     * 
     * @return array
     */
    public function toArray(){
        $array = get_object_vars($this);
        return $array;
    }

}