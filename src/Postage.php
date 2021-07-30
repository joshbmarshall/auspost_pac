<?php

namespace Cognito\AuspostPAC;

/**
 * Definition of a Domestic Postage Price
 *
 * @package Cognito\AuspostPAC
 * @author Josh Marshall <josh@jmarshall.com.au>
 *
 * @property string $service
 * @property string $delivery_time
 * @property float $total_cost
 * @property Cost[] $costs
 */
class Postage {

	public $service;
	public $delivery_time;
	public $total_cost;
	public $costs = [];
	public $raw_details = [];

	public function __construct($details) {
		foreach ($details as $key => $data) {
			if ($key == 'costs') {
				$costs = [];
				foreach ($data as $cost) {
					$costs[] = new Cost($cost);
				}
				$this->$key = $costs;
			} else {
				$this->$key = $data;
			}
		}
		$this->raw_details = $details;
	}
}
