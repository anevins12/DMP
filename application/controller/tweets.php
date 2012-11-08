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
		$tweets = $tweetsmodel->getTweets( NULL );

		//set the sentiment values
//		foreach ($tweets as $tweet){
//			$this->getANEWSentiment($tweet);
//		}
		
//		$this->setLocations();
		$this->getGoogleLineGraphFormat($tweets);

		//return $tweets;

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

				//count how many times that word appears in the tweet
				// at the moment the frequency is picking up whether the combination of letters appear in the sentece.
				// its not counted whether that word is followed by a space, its counting if that word is anywhere in the sentence.
				// for now I've used the spaces to represent the word, but this may exclude words at the start and end of sentences.
				// including words with punctuation.
				$frequency = substr_count( $tweet_text , ' ' . $tweet_word . ' ' );
				
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

	function setLocations() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets( NULL );

		foreach ( $tweets as $tweet ) {

			// Check for empty locations on tweets
			if ( !empty ( $tweet->geo_lat ) && !empty ( $tweet->geo_long ) ) {
				
				$location = $this->getGeocoder( $tweet->geo_lat, $tweet->geo_long );
				$city = $location->getCity();
				
				// Check if the GeoCoder returns a country code that is not null/ empty
				if ( !empty ( $city ) || isset ( $city ) ) {

					// Set the Country Code aside of each tweet.
					$tweetsmodel->insertTweetCity( $tweet->tweet_id, $city );

				}
			}		

		}
		
	}

	function getGoogleLineGraphFormat( $data ) {
		
	}
	
}
?>
