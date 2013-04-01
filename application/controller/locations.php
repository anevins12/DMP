<?php

/**
 * Interacts with the Geocoder API to create an object
 *
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 */
class Locations {

	function __construct() {
		
		include_once( dirname(__FILE__) . '/../vendor/autoload.php' );

	}

	/**
	 * Calls to the Geocoder class and creates a Geocoder object
	 *
	 * @return  object
	 */
	function geocoder() {
	 
		// Create an adapter
		$adapter  = new \Geocoder\HttpAdapter\BuzzHttpAdapter();

		// Create a Geocoder object and pass it your adapter
		$geocoder = new \Geocoder\Geocoder();

		// Then, register all providers your want
		$geocoder->registerProviders(array(

//			new \Geocoder\Provider\YahooProvider(
//				$adapter, '<YAHOO_API_KEY>'
//			),
//			new \Geocoder\Provider\IpInfoDbProvider(
//				$adapter, '<IPINFODB_API_KEY>'
//			),
//			new \Geocoder\Provider\HostIpProvider($adapter),
//
			// your provider here
			new \Geocoder\Provider\OpenStreetMapsProvider($adapter)
		));

		return $geocoder;

	}
}


?>