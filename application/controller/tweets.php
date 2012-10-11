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
include_once ( 'locations.php' );

class Tweets extends Locations{

    function __construct() {
		include_once ( '../model/tweetsmodel.php' );
		include_once ( '../model/sentimentmodel.php' );
	}

	public function index() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets( NULL );

		$this->setLocations();

//Getting the paramter to pass to the set140Sentiment function
		$tweets_sentiment = $this->get140Sentiment($tweets);
		$tweets_sentiment = json_decode($tweets_sentiment);
		$tweets_sentiment = $tweets_sentiment->data;

		$this->set140Sentiment($tweets_sentiment);

		return $tweets;

	}

	public function getANEWSentiment( $tweet ) {
		$words_array = array();
		$sentiment = array();
		$multiplication = array();
		$anew_sentiment = 0;
		//need ANEW dataset

		$words_array[] = str_word_count( $tweet->tweet_text, 1 );

		foreach ( $words_array as $words_array_inner ) {

			foreach ( $words_array_inner as $word ) {

				$frequency = str_word_count($word);

				if( isset ( $anew_example[ $word ] ) ) {
					$anew_sentiment = $anew_example[ $word ];
					$multiplication[] = $frequency * $anew_sentiment;
				}

			}

			$multiplication_sum = array_sum( $multiplication );

		}

		$sentiment = $multiplication_sum / $frequency;

		$sentimentmodel = new sentimentmodel();
		$sentimentmodel->insertSentiment( $tweet->tweet_id, $sentiment ); // find out why your sentiment is incrementing!!

		unset( $multiplication );

		return $sentiment;

	}

	function get140Sentiment ( $tweets ) {
		$app_id = 'andrew2.nevins@live.uwe.ac.uk';
		$url = "http://www.sentiment140.com/api/bulkClassifyJson?appid=$app_id";
		
		$data = array('data' => array());

		foreach ( $tweets as $tweet ) {
			$data['data'][] = array('text'=> $tweet->tweet_text);
		}

		$json_array = json_encode( $data );

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		//send the array
		curl_setopt($ch,CURLOPT_POSTFIELDS, $json_array);
		//capture the response, instead of outputting it straight to the webpage
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//execute post
		$result = curl_exec($ch);

		$curl_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//close connection
		curl_close($ch);

		if ( $curl_status == 200 ) {
			return $result;
		}

		else {
			return 'Sentiment140 Error: ' .$curl_status;
		}

	}

	function set140Sentiment( $tweets_sentiment ) {

		foreach ( $tweets_sentiment as $tweet_sentiment ) {
			$tweetsmodel = new Tweetsmodel;
			$sentiment_value = $tweet_sentiment->polarity;
			$tweet_text = $tweet_sentiment->text;

			$query = $tweetsmodel->set140Sentiment($sentiment_value, $tweet_text);
		}

	}

	function interactWeFeelFine() {
		//example of We Feel Fine Api's call to include locations
		define('FEEL_FINE_API','http://api.wefeelfine.org:8080/ShowFeelings?display=xml&returnfields=country,
state,city,lat,lon,conditions&limit=100000');
		$xml = simplexml_load_file(API);

		return $xml;
	}

	function getTweetsFromAPI() {
		define('SAMPLE_TWEETS_API', 'https://stream.twitter.com/1.1/statuses/sample.json');
		define('AUTH_TWEETS', 'https://api.twitter.com/oauth/authorize?oauth_token=208726108-e0qS5K2a97ngzCqQKsZjCpC6p7dkoeUhvXERPsml');
		
		$json = file_get_contents(AUTH_TWEETS);
		$json_output = json_decode($json);

		return $json_output;

	}

	function getGeocoder( $lat = 0, $long = 0 ) {
		include_once ( '../controller/locations.php' );

		$geocoder = new Locations();
		$geocoder = $geocoder->geocoder();
			
		$result = $geocoder->geocode( $lat ,$long );

		return $result;

	}

	function setLocations() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets( NULL );

		foreach ( $tweets as $tweet ) {

			// Check for empty locations on tweets
			if ( !empty ( $tweet->geo_lat ) && !empty ( $tweet->geo_long ) ) {
				
				$location = $this->getGeocoder( $tweet->geo_lat, $tweet->geo_long );
				$countryCode = $location->getCountryCode();
				
				// Check if the GeoCoder returns a country code that is not null/ empty
				if ( !empty ( $countryCode ) || isset ( $countryCode ) ) {

					// Set the Country Code aside of each tweet.
					$tweetsmodel->insertTweetCountryCode( $tweet->tweet_id, $countryCode );

				}
			}		

		}
		
	}
	
}
?>
