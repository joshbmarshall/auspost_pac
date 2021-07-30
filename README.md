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
```
