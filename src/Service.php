<?php

namespace Cognito\AuspostPAC;

/**
 * Definition of a Domestic Postage Service
 *
 * @package Cognito\AuspostPAC
 * @author Josh Marshall <josh@jmarshall.com.au>
 *
 * @property string $code
 * @property string $name
 * @property float $price
 * @property int $max_extra_cover
 * @property Option[] $options
 */
class Service {

    public $code;
    public $name;
    public $price;
    public $max_extra_cover;
    public $options = [];
    public $raw_details = [];

    public function __construct($details) {
        foreach ($details as $key => $data) {
            if ($key == 'options') {
                $options = [];
                foreach ($data['option'] as $option) {
                    $options[] = new Option($option);
                }
                $this->$key = $options;
            } else {
                $this->$key = $data;
            }
        }
        $this->raw_details = $details;
    }
}
