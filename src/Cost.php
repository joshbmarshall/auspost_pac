<?php

namespace Cognito\AuspostPAC;

/**
 * Definition of a Domestic Postage Price
 *
 * @package Cognito\AuspostPAC
 * @author Josh Marshall <josh@jmarshall.com.au>
 *
 * @property string $item
 * @property float $cost
 */
class Cost {

	public $item;
	public $cost;
	public $raw_details = [];

	public function __construct($details) {
		foreach ($details as $key => $data) {
			$this->$key = $data;
		}
		$this->raw_details = $details;
	}
}
