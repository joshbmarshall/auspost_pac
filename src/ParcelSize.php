<?php

namespace Cognito\AuspostPAC;

/**
 * Definition of a Parcel Size
 *
 * @package Cognito\AuspostPAC
 * @author Josh Marshall <josh@jmarshall.com.au>
 *
 * @property string $code
 * @property string $name
 * @property string $value
 */
class ParcelSize {

    public $code = '';
    public $name = '';
    public $value = '';
    public $raw_details = [];

    public function __construct($details) {
        foreach ($details as $key => $data) {
            $this->$key = $data;
        }
        $this->raw_details = $details;
    }
}
