# Australia Post PAC API

Interact with the AusPost PAC API

## Installation

Installation is very easy with composer:

    composer require cognito/auspost_pac

## Setup

Create a developer account at Australia Post at https://developers.auspost.com.au/apis/pacpcs-registration

## Usage

```
<?php
	$auspost = new \Cognito\AuspostPAC\AuspostPAC('Your API Key');

	// Get list of Parcel Sizes
	$parcelSizes = $auspost->getParcelSizes();

	// Get a quote for delivery options using known weight and box dimensions
	$quotes = $auspost->startQuote()
		->setFromPostcode(4500)
		->setToPostcode(4127)
		->setParcelDimensions(10, 8, 22)
		->setParcelWeight(2.3)
		->getServices();

	// Get a quote for delivery options using known weight and approximate box dimensions from cubic weight
	$quotes = $auspost->startQuote()
		->setFromPostcode(4500)
		->setToPostcode(4127)
		->setParcelWeight(2.3)
		->setParcelCubicWeight(4)
		->getServices();

	// Get a quote for delivery options using cubic weight
	$quotes = $auspost->startQuote()
		->setFromPostcode(4500)
		->setToPostcode(4127)
		->setParcelCubicWeight(4)
		->getServices();

	// Get a total price for a delivery of a certain type
	$price = $auspost->startQuote()
		->setFromPostcode(4500)
		->setToPostcode(4127)
		->setParcelCubicWeight(4)
		->getTotalPrice('AUS_PARCEL_REGULAR');
```
