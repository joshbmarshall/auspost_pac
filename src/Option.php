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
 * @property int $max_extra_cover
 * @property Option[] $suboptions
 */
class Option {

    public $code;
    public $name;
    public $price;
    public $suboptions = [];
    public $raw_details = [];

    public function __construct($details) {
        foreach ($details as $key => $data) {
            if ($key == 'suboptions') {
                $options = [];
                foreach ($data as $option) {
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
