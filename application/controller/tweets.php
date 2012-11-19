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
		include_once ( dirname(__FILE__) . '/../model/tweetsmodel.php' );
		include_once ( dirname(__FILE__) . '/../model/sentimentmodel.php' );
	}

	public function index() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets();

		//set the sentiment values
//		foreach ($tweets as $tweet){
//			$this->getANEWSentiment($tweet);
//		}
		
	//	$this->setLocations($tweets);

		return $tweets;

	}

	public function getANEWSentiment( $tweet ) {

		$anew_dataset_file    = file_get_contents(dirname(__FILE__) . '/../anew_2010/ANEW2010All.txt');
		$rows = explode( "\n", $anew_dataset_file );

		//remove the headings
		array_shift( $rows );
		
		$valence = array();

		// Get the happiness value per word
		foreach ( $rows as $row ) {
			$explode = explode("	", $row );
			$valence[$explode[0]] = $explode[2];
		}

		$happiness_array = $valence;

		$words_array = array();
		$sentiment = array();
		$multiplication = array();
		$tweet_text = $tweet->tweet_text;
		/*Test tweet text */
//		$tweet_text = "me me me me me me me me me me";
		$tweet_words = explode( ' ' , $tweet_text );
		$flag = false;
		$count_multiplication_occurrence = 1;

		foreach ( $tweet_words as $tweet_word ) {

			if ( $tweet_word ) {

				//remove punctuation after each word
				# URL that generated this code:
				# http://txt2re.com/index-php.php3?s=Button.&-9

				$re1='.*?';	# Non-greedy match on filler
				$re2='(\\.)';	# Any Single Character 1

				if ($c=preg_match_all ("/".$re1.$re2."/is", $tweet_word, $matches)) {
					 $c1=$matches[1][0];
					  
					 $tweet_word_refined = str_replace($c1, '', strtolower($tweet_word));
				}
				else {
					$tweet_word_refined = $tweet_word;
				}
				#end of generated code

				//refine tweet sentence
				//http://stackoverflow.com/questions/5233734/how-to-strip-punctuation-in-php
				$tweet_text_refined = preg_replace( "/(?![.=$'€%-])\p{P}/u", "", $tweet_text );

				//send each word into an array, to check frequency later
				$tweet_text_refined_array = explode( ' ', $tweet_text_refined );
				

				//count how many times that word appears in the tweet
				$frequency = array_count_values( $tweet_text_refined_array );

				if ( isset($frequency[$tweet_word_refined]) ) {
					$frequency = $frequency[ $tweet_word_refined ];
				}
				else {
					$frequency = 1;
				}

				
				//check if the tweet's word is within the English language
				if ( isset ( $happiness_array[ $tweet_word_refined ] ) ) {
					
					//grab ANEW sentiment for that word
					$happiness_word = $happiness_array[ $tweet_word_refined ];
		
					//increment the count of how many words have been calculated
					$count_multiplication_occurrence++;

					if ( in_array( $happiness_word * $frequency, $multiplication) && $frequency > 1)  {
						// Don't apply the multiplication if the word has already been calculated
					}
					else {
						//multiply the ANEW sentiment for that word, by the frequency
						$multiplication[] =  $happiness_word * $frequency;
					}

				}
				
			} 
			
		}

		$multiplication_sum = array_sum( $multiplication );

		if ( $count_multiplication_occurrence ) {
			
			//maybe need to convert integer to float
			$sentiment = $multiplication_sum / $count_multiplication_occurrence;

			//insert sentiment into the database
			$this->setANEWSentiment( $tweet, $sentiment );
			$flag = true;
			
		}
		
		//Clear the multiplication array for the next tweet
		unset( $multiplication );

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

			//wont work because I've changed the setSentiment function to work with ANEWSentiment
			//$query = $tweetsmodel->setSentiment( $tweet_text, $sentiment_value );
		}

	}

	function setANEWSentiment( $tweet, $sentiment ) {

		$tweetsmodel = new Tweetsmodel;
		$query = $tweetsmodel->setSentiment( $tweet, $sentiment );

		if ( $query ) {
			return true;
		}
		
		return false;

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

		$locations = new Locations();
		//initiate geocoder
		$geocoder = $locations->geocoder();
		
		$result = $geocoder->reverse( $lat, $long );

		return $result;

	}

	function setLocations( $tweets ) {

		$tweetsmodel = new Tweetsmodel;

		foreach ( $tweets as $tweet ) {

			// Check for empty locations on tweets
			if ( !empty ( $tweet->geo_lat ) && !empty ( $tweet->geo_long ) ) {

				
				if (empty($tweet->city) && !empty($tweet->sentiment)){
					$location = $this->getGeocoder( $tweet->geo_lat, $tweet->geo_long );
					$city = $location->getCity();
				}
				
				// Check if the GeoCoder returns a country code that is not null/ empty
				if ( !empty ( $city ) || isset ( $city ) ) {
					
					// Set the Country Code aside of each tweet.
					$tweetsmodel->insertTweetCity( $tweet->tweet_id, $city );

				}

			}		

		}
		
	}

	function getGoogleLineGraphFormat( $data ) {

		//sorry, hard-coding it because I can't get my head around it otherwise
		//HALLOWEEN & FIREWORKS

		
		$day1 = 20121029;
		$day2 = 20121030;
		$day3 = 20121031;
		$day4 = 20121101;
		$day5 = 20121102;
		$day6 = 20121103;
		$day7 = 20121104;
		$day8 = 20121105;
		$day9 = 20121106;

		$day1Tweets = array();
		$day2Tweets = array();
		$day3Tweets = array();
		$day4Tweets = array();
		$day5Tweets = array();
		$day6Tweets = array();
		$day7Tweets = array();
		$day8Tweets = array();
		$day9Tweets = array();

	

		foreach( $data as $tweet ) {

			$time = $tweet->created_at;
			$day = substr( $time, 0, 10 );
			$explode_day = explode( "-", $day );
			$implode_day = implode( '', $explode_day );
			$implode_day = intval( $implode_day );
				
			if ( $implode_day == $day1 ) {
				$day1Tweets[] = $tweet;
			}
			if ( $implode_day == $day2 ) {
				$day2Tweets[] = $tweet;
			}
			if ( $implode_day == $day3 ) {
				$day3Tweets[] = $tweet;
			}
			if ( $implode_day == $day4 ) {
				$day4Tweets[] = $tweet;
			}
			if ( $implode_day == $day5 ) {
				$day5Tweets[] = $tweet;
			}
			if ( $implode_day == $day6 ) {
				$day6Tweets[] = $tweet;
			}
			if ( $implode_day == $day7 ) {
				$day7Tweets[] = $tweet;
			}
			if ( $implode_day == $day8 ) {
				$day8Tweets[] = $tweet;
			}
			if ( $implode_day == $day9 ) {
				$day9Tweets[] = $tweet;
			}
			
		}

		
		$days = array();
		$days = array('day1' => array( $day1 => $day1Tweets ), 'day2' => array( $day2 => $day2Tweets ), 'day3' => array( $day3 => $day3Tweets ),
				  'day4' => array( $day4 => $day4Tweets ), 'day5' => array( $day5 => $day5Tweets ), 'day6' => array( $day6 => $day6Tweets ),
				  'day7' => array( $day7 => $day7Tweets ), 'day8' => array( $day8 => $day8Tweets ), 'day9' => array( $day9 => $day9Tweets ));


		//now you can normalise the data for each day
		// http://sonia.hubpages.com/hub/stddev

		
		$sentiment = array();
		$normalised_sentiment = array();
		
		//average quantity of tweets, from 7 days. Day 2,3,4,5,6,8,9
		$i= 0;

		foreach ( $days as $day ) {
			
			foreach ( $day as $tweets ){

				foreach ( $tweets as $tweet ) {
					$sentiment[] = $tweet->sentiment;
				}

			}			
			
			//Get the Mean
			$sentiment_sum = array_sum( $sentiment );
			$sentiment_no = count( $sentiment );

			$sentiment_mean = $sentiment_sum / $sentiment_no;


			//Get the deviations
			$deviations = array();

			foreach ( $sentiment as $sentimenti ) {

				$deviations[] = $sentimenti - $sentiment_mean;

			}

			//Square each deviation
			$squares = array();

			foreach ( $deviations as $deviation ) {

				$squares[] = $deviation * $deviation;

			}

			//Sum all squares
			$sum_squares = array_sum( $squares );

			//Divide sum of squares by items in list - 1
			$sum_squares_division = $sum_squares / ( count( $squares ) - 1);

			//Square root of Division sum of squares by items in list -1 result
			$deviation = sqrt( $sum_squares_division );

			$normalised_sentiment[] = $deviation;

		}


		//not doing day1 & day8 because only 61 and 0 tweets were picked up
		unset ( $normalised_sentiment[ 0 ] );
		
		return $normalised_sentiment;

	}
	
}
?>
