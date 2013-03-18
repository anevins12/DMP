<?php
class Cities{

	function __construct() {
		include_once ( dirname(__FILE__) . '/../model/tweetsmodel.php' );
		include_once ( dirname(__FILE__) . '/tweets.php' );
	}

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
