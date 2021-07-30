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

    public function __construct($details) {
        $this->raw_details = $details;
    }
}
