<?php

namespace Cognito\AuspostPAC;

/**
 * A shipment, made up of one or more parcels
 *
 * @package Cognito\AuspostPAC
 * @author Josh Marshall <josh@jmarshall.com.au>
 *
 * @property AuspostPAC $_auspost
 * @property string $from_postcode
 * @property string $to_postcode
 * @property float $length
 * @property float $width
 * @property float $height
 * @property float $weight
 * @property float $cubic_weight
 * @property float $cubic_weight_multiplier
 */
class Quote {

	private $_auspost;
	public $from_postcode;
	public $to_postcode;
	public $length = 0;
	public $width  = 0;
	public $height = 0;
	public $weight;
	public $cubic_weight = 0;
	public $cubic_weight_multiplier = 250;

	public function __construct($api) {
		$this->_auspost = $api;
	}

	/**
	 * Add the From Postcode
	 * @param int $data The Australian postcode to deliver to
	 * @return $this
	 */
	public function setFromPostcode($data) {
		$this->from_postcode = $data;
		return $this;
	}

	/**
	 * Add the To Postcode
	 * @param int $data The Australian postcode to deliver to
	 * @return $this
	 */
	public function setToPostcode($data) {
		$this->to_postcode = $data;
		return $this;
	}

	/**
	 * Set the physical size of the parcel in centimeters
	 * @param int $length
	 * @param int $width
	 * @param int $height
	 * @return $this
	 */
	public function setParcelDimensions($length, $width, $height) {
		$this->length = $length;
		$this->width  = $width;
		$this->height = $height;
		return $this;
	}

	/**
	 * Set the actual weight of the parcel in kilograms
	 * @param float $weight
	 * @return $this
	 */
	public function setParcelWeight($weight) {
		$this->weight = $weight;
		return $this;
	}

	/**
	 * Set the cubic weight of the parcel. This is used if a physical size isn't known but the approximate volume is.
	 * Uses the Australia Post domestic cubic weight to approximate parcel size
	 * @param float $weight
	 * @param float $multiplier Defaults to 250
	 * @return $this
	 */
	public function setParcelCubicWeight($weight, $multiplier = 250) {
		if (!$this->weight) {
			$this->weight = $weight;
		}
		if (!$multiplier) {
			$multiplier = 250;
		}
		$this->cubic_weight = $weight;
		$this->cubic_weight_multiplier = $multiplier;
		// Cubic weight = length (m) * width (m) * height (m) * multiplier
		// Each side in cm = (weight * 1000000 / multiplier) ^1/3
		$cube = round(pow($weight * 1000000 / $multiplier, 1 / 3), 2);
		$this->length = $cube;
		$this->width = $cube;
		$this->height = $cube;
		return $this;
	}

	/**
	 * Get list of services and prices for this parcel
	 * @return Service[]
	 */
	public function getServices() {
		$services = [];
		$data = json_decode($this->_auspost->sendGetRequest('/postage/parcel/domestic/service.json', [
			'from_postcode' => $this->from_postcode,
			'to_postcode'   => $this->to_postcode,
			'length'        => $this->length,
			'width'         => $this->width,
			'height'        => $this->height,
			'weight'        => $this->weight,
		]), true);

		foreach ($data['services']['service'] as $service) {
			$services[] = new Service($service);
		}
		return $services;
	}

	/**
	 * Get the total price for the service code option
	 * @param string $service_code
	 * @return Postage
	 */
	public function getTotalPrice($service_code) {
		$data = json_decode($this->_auspost->sendGetRequest('/postage/parcel/domestic/calculate.json', [
			'from_postcode' => $this->from_postcode,
			'to_postcode'   => $this->to_postcode,
			'length'        => $this->length,
			'width'         => $this->width,
			'height'        => $this->height,
			'weight'        => $this->weight,
			'service_code'  => $service_code,
		]), true);

		return new Postage($data['postage_result']);
	}
}
