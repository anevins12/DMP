<?php

/**
 * Retrieves data from the 'tweets' table from the 'tweetsmodel' class.
 *
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 * @package My work
 */
class Cities{

	function __construct() {
		include_once ( dirname(__FILE__) . '/../model/tweetsmodel.php' );
		include_once ( dirname(__FILE__) . '/tweets.php' );
	}

	/**
	 * Retrieves a small sample of tweets from main United Kingdom cities
	 *
	 * @return  JSONstring
	 */
	function allCities() {

		$tweetsmodel = new Tweetsmodel;
		$tweetscontroller = new Tweets();
		$tweets = $tweetsmodel->getTweets(); 
		$happiest_cities = $tweetscontroller->getAverageSentimentPerCity($tweets);
		$happiest_cities = $happiest_cities['cities_tweets'];

		//shorten the array down from 900-ish cities to 49
		foreach ($happiest_cities as $k => $v) {
			$keys = array_keys($v);
			$key = $keys[0]; 
			$cities[$key] =  array_slice( $v[$key],0,10 );
		}
		ksort($cities);
		
		return json_encode($cities);
	}
}

$cities = new Cities();
echo $cities->allCities();
?>
