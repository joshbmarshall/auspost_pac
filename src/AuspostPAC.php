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

	private $api_key        = null;
	private $test_mode      = null;

	const API_SCHEME = 'https://';
	const API_HOST   = 'digitalapi.auspost.com.au';

	/**
	 *
	 * @param string $api_key The AusPost API Key
	 * @param bool $test_mode Whether to use test mode or not
	 */
	public function __construct($api_key, $test_mode = false) {
		$this->api_key = $api_key;
		$this->test_mode = $test_mode;
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
		foreach ($data as $item) {
			$parcels[] = new ParcelSize($item);
		}

		return $parcels;
	}

	/**
	 * Sends an HTTP GET request to the API.
	 *
	 * @param string $action the API action component of the URI
	 *
	 * @throws Exception on error
	 */
	private function sendGetRequest($action, $data = []) {
		return $this->sendRequest($action, $data, 'GET');
	}

	/**
	 * Sends an HTTP POST request to the API.
	 *
	 * @param string $action the API action component of the URI
	 * @param array  $data   assoc array containing the data to send
	 *
	 * @throws Exception on error
	 */
	private function sendPostRequest($action, $data) {
		return $this->sendRequest($action, $data, 'POST');
	}

	/**
	 * Sends an HTTP PUT request to the API.
	 *
	 * @param string $action the API action component of the URI
	 * @param array  $data   assoc array containing the data to send
	 *
	 * @throws Exception on error
	 */
	private function sendPutRequest($action, $data) {
		return $this->sendRequest($action, $data, 'PUT');
	}

	/**
	 * Sends an HTTP DELETE request to the API
	 *
	 * @param string $action
	 * @param mixed $data
	 * @return void
	 * @throws \Exception
	 */
	private function sendDeleteRequest($action, $data) {
		return $this->sendRequest($action, $data, 'DELETE');
	}

	/**
	 * Sends an HTTP POST request to the API.
	 *
	 * @param string $action the API action component of the URI
	 * @param array  $data   assoc array containing the data to send
	 * @param string $type   GET, POST, PUT, DELETE
	 *
	 * @throws Exception on error
	 */
	private function sendRequest($action, $data, $type) {
		$encoded_data = $data ? json_encode($data) : '';

		$url = self::API_SCHEME . self::API_HOST . $action;
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
