<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of locations
 *
 * @author andrew
 */
class Locations {

	function __construct() {
		
		require '../vendor/autoload.php';

	}

	function geocoder() {
	 
		// Create an adapter
		$adapter  = new \Geocoder\HttpAdapter\BuzzHttpAdapter();

		// Create a Geocoder object and pass it your adapter
		$geocoder = new \Geocoder\Geocoder();

		// Then, register all providers your want
		$geocoder->registerProviders(array(

			new \Geocoder\Provider\YahooProvider(
				$adapter, '<YAHOO_API_KEY>'
			),
			new \Geocoder\Provider\IpInfoDbProvider(
				$adapter, '<IPINFODB_API_KEY>'
			),
			new \Geocoder\Provider\HostIpProvider($adapter),
			
			// your provider here
		));

		return $geocoder;

	}
}


?>