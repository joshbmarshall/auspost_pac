<?php

namespace Cognito\AuspostPAC;

use Exception;

/**
 * Interact with the Australian Post API
 *
 * @package Cognito
 * @author Josh Marshall <josh@jmarshall.com.au>
 */
class AuspostPAC {

	private $api_key = null;

	const API_SCHEME = 'https://';
	const API_HOST   = 'digitalapi.auspost.com.au';

	/**
	 *
	 * @param string $api_key The AusPost API Key
	 */
	public function __construct($api_key) {
		$this->api_key = $api_key;
	}

	/**
	 * Get list of Australia Post standard parcel sizes
	 *
	 * @return ParcelSize[] the parcel sizes
	 * @throws Exception
	 */
	public function getParcelSizes() {
		$data = json_decode($this->sendGetRequest('/postage/parcel/domestic/size.json' . $this->account_number), true);
		$parcels = [];
		foreach ($data['sizes']['size'] as $item) {
			$parcels[] = new ParcelSize($item);
		}

		return $parcels;
	}

	/**
	 * Start point of a quote
	 * @return Quote
	 */
	public function startQuote() {
		return new Quote($this);
	}

	/**
	 * Sends an HTTP GET request to the API.
	 *
	 * @param string $action the API action component of the URI
	 * @param array $data optional key => value data to send in the url
	 * @return string raw body data
	 * @throws Exception on error
	 */
	public function sendGetRequest($action, $data = []) {
		$url = self::API_SCHEME . self::API_HOST . $action;
		if ($data) {
			$url .= '?' . http_build_query($data);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('AUTH-KEY: ' . $this->api_key));
		$rawBody = curl_exec($ch);

		if (!$rawBody) {
			throw new Exception('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}

		return $rawBody;
	}
}
