<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tweets
 *
 * @author andrew
 */
class Tweets {

    function __construct() {
		include_once ( '../model/tweetsmodel.php' );
	}

	public function index() {

		$tweetsmodel = new Tweetsmodel;

		return	$tweetsmodel->getAllTweets( NULL, '10' );

	}

	public function findContinents() {

		include_once ( 'locations.php' );

		$locations = new Locations();

		$geocoder = $locations->geocoder();

		var_dump($geocoder);exit;

		// Use it!
		$result = $geocoder->geocode('Eiffel Tower');
		// Or
		$result = $geocoder->geocode('68.145.37.34');

		
//		$tweets = $this->index();
//		$locations = array();
//
//		foreach ( $tweets as $tweet ) {
//
//			$locations[] = $tweet->geo_lat . LAT_LONG_SEPARATOR . $tweet->geo_long;
//
//		}

		var_dump($locations);exit;

	}
	
}
?>
