<?php
/**
 * Handles displaying and manipulation of all tweet data
 * Some funcitons should be in the tweetsmodel - Sorry if this class tries to play God.
 *
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 * @used-by /application/view/all/index.php
 * @package My work
 */
include_once ( 'locations.php' );

class Tweets {

    function __construct() {
		include_once ( dirname(__FILE__) . '/../model/tweetsmodel.php' );
		include_once ( dirname(__FILE__) . '/../model/sentimentmodel.php' );
	}

	/**
	 * Runs as default function. It calls upon other functions within this controller and the tweetsmodel.
	 *
	 * @return  JSONstring
	 */
	public function index() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets();		
		$this->getTweetQuantities();
		$AverageTweetsJSON = $this->getAverageSentimentPerCity($tweets);

		return $AverageTweetsJSON;

	}

	/**
	 * Calls the tweetsmodel function to get the recent tweets
	 *
	 * @return  array
	 */
	public function getRecentTweets() {

		$tweetsmodel = new Tweetsmodel;
		$recent_tweets = $tweetsmodel->getRecentTweets();

		return $recent_tweets;

	}

	/**
	 * Uses the tweetsmodel to get all tweets.
	 * Then narrow down the tweets to only those belonging to major cities in the UK.
	 * And construct an array with the amount of tweets that have certain sentimental values
	 *
	 * @return  array
	 */
	public function getTweetQuantities() {

		$tweetsmodel = new Tweetsmodel;
		$tweets = $tweetsmodel->getTweets();

		$two = 0;
		$four = 0;
		$six = 0;
		$eight = 0;
		$ten = 0;
		$quantities = array('2' => $two, '4' => $four, '6' => $six, '8' => $eight, '10' => $ten);
		$cities_string = '

					 Bath	 Birmingham	 Bradford
					 Brighton and Hove	 Bristol	 Cambridge
					 Canterbury	 Carlisle	 Chester
					 Chichester	 Coventry	 Derby
					 Durham	 Ely	 Exeter
					 Gloucester	 Hereford	 Kingston upon Hull
					 Lancaster	 Leeds	 Leicester
					 Lichfield	 Lincoln	 Liverpool
					 City of London	 Manchester	 Newcastle upon Tyne
					 Norwich	 Nottingham	 Oxford
					 Peterborough	 Plymouth	 Portsmouth
					 Preston	 Ripon	 Salford
					 Salisbury	 Sheffield	 Southampton
					 St Albans	 Stoke-on-Trent	 Sunderland
					 Truro	 Wakefield	 Wells
					 Westminster	 Winchester	 Wolverhampton
					 Worcester	 York

					 Bangor	 Cardiff	 Newport
					 St Davids	 Swansea

					 Aberdeen	 Dundee	 Edinburgh
					 Glasgow	 Inverness	 Stirling

					 Armagh	 Belfast	 Londonderry
					 Lisburn	 Newry

					';

		foreach ($tweets as $tweet) {

			//Check if the tweet's city has a value. If it has, check whether it's within the list of popular cities (above).
			if ( isset( $tweet->city ) && strstr( $cities_string, $tweet->city ) ) {

				$sentiment = $tweet->sentiment;

				//This should be a switch statement - sorry
				//It just checks whether the sentiment is within a particular range.
				//When it matches a range, it increments the associative array's value for that range.
				//It basically counts how many tweets are sad and happy.
				if ($sentiment <= 2) {
						$quantities['2']++;
				}

				if ($sentiment > 2 && $sentiment <= 4) {
					$quantities['4']++;
				}

				if ($sentiment > 4 && $sentiment <= 6) {
					$quantities['6']++;
				}

				if ($sentiment > 6 && $sentiment <= 8) {
					$quantities['8']++;
				}

				if ($sentiment > 8 && $sentiment <= 10) {
					$quantities['10']++;
				}
			}

		}
		
		
	}

	/**
	 * Get both the happy tags and sad tags data from the tweets model
	 * Instead of returning data, write it directly to a JSON file.
	 */
	public function getTweetTags() {
		$tweetsmodel = new Tweetsmodel;
		$sadTags= $tweetsmodel->getSadTweetTags();
		$happyTags = $tweetsmodel->getHappyTweetTags();
	
		$this->writeJSONFile($sadTags, 'sadTweetTags');
		$this->writeJSONFile($happyTags, 'happyTweetTags');
	}

	/**
	 * Part of the sentiment analysis process - This gets the tweet's sentimental value in conjunction with the ANEW dataset
	 * Uses the tweetsmodel to get all tweets.
	 * Then narrow down the tweets to only those belonging to major cities in the UK.
	 * And construct an array with the amount of tweets that have certain sentimental values
	 *
	 */
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

			//Applying the patterns from the Linear Regression processes.
			//'refineTweet' returns a numeric value
			if ( $refined_sentiment = $this->refineTweet( $tweet ) ) {
				$refined_sentiment = $refined_sentiment * $sentiment;
			}

			//insert sentiment into the database
			$this->setANEWSentiment( $tweet, $refined_sentiment );
			$flag = true;
			
		}
		
		//Clear the multiplication array for the next tweet
		unset( $multiplication );

	}

	/**
	 * Uses the 140Sentiment API to get sentiment on tweets
	 * [Not active in the application]
	 * Decided not to go with this because the API only returned 3 values.
	 * Values of zero, 2 or four.
	 * I wanted more range.
	 *
	 * @return  array | string
	 */
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

	/**
	 * Just inserting the value from the get140Sentiment function to into the database.
	 *
	 * @return  boolean
	 */
	function set140Sentiment( $tweets_sentiment ) {

		foreach ( $tweets_sentiment as $tweet_sentiment ) {
			$tweetsmodel = new Tweetsmodel;
			$sentiment_value = $tweet_sentiment->polarity;
			$tweet_text = $tweet_sentiment->text;

			//wont work because I've changed the setSentiment function to work with ANEWSentiment
			$query = $tweetsmodel->setSentiment( $tweet_text, $sentiment_value );
		}

		return true;

	}

	/**
	 * Updates a row from the tweets table to hold a sentimental value
	 *
	 * @return  boolean
	 */
	function setANEWSentiment( $tweet, $sentiment ) {

		$tweetsmodel = new Tweetsmodel;
		$query = $tweetsmodel->setSentiment( $tweet, $sentiment );

		if ( $query ) {
			return true;
		}
		
		return false;

	}

	/**
	 * Uses the WeFeelFine API to call on all feelings from everywhere
	 * I didn't use this function or API because there was little data to collect,
	 * Especially when narrowing down data to "I feel" excerpts.
	 *
	 * @return  xml
	 */
	function interactWeFeelFine() {
		//example of We Feel Fine Api's call to include locations
		define('FEEL_FINE_API','http://api.wefeelfine.org:8080/ShowFeelings?display=xml&returnfields=country,
state,city,lat,lon,conditions&limit=100000');
		$xml = simplexml_load_file(API);

		return $xml;
	}

	/**
	 * Calls on the Geocoder object from the Locations controller
	 * Gets data about that location
	 *
	 * @param   $long   The longitude coordinate
	 * @param   $lat    The latitude coordinate
	 * @return  object;
	 */
	function getGeocoder( $lat = 0, $long = 0 ) {
		include_once ( '../controller/locations.php' );

		$locations = new Locations();
		//initiate geocoder
		$geocoder = $locations->geocoder();

		//has to reverse the coordinates to retrieve town and city names
		$result = $geocoder->reverse( $lat, $long );

		return $result;

	}

	/**
	 * Sets the city names from the geolocations of tweets 
	 *
	 * @param   $tweets   An array of all tweets 
	 * @return  true;
	 */
	function setLocations( $tweets ) {

		$tweetsmodel = new Tweetsmodel;

		foreach ( $tweets as $tweet ) {

			// Check for empty locations on tweets
			if ( !empty ( $tweet->geo_lat ) && !empty ( $tweet->geo_long ) ) {

				//Only apply this function to tweets that have not yet received a city name
				//And have an empty sentiment
				if (empty($tweet->city) && !empty($tweet->sentiment)){

					//Call the getGeocoder function from within this controller
					$location = $this->getGeocoder( $tweet->geo_lat, $tweet->geo_long );

					//Pick off only the Geocoder city attribute's value from the object
					$city = $location->getCity();

				}
				
				// Check if the GeoCoder returns a city that is not null/ empty
				if ( !empty ( $city ) || isset ( $city ) ) {
					
					// Set the Country Code aside of each tweet.
					$tweetsmodel->insertTweetCity( $tweet->tweet_id, $city );

				}

			}		

		}
		
		return true;
		
	}

	/**
	 * Constructs data ready to be used within GoogleGraph's line graph API.
	 * [Not active in the application]
	 * I scrapped this because the line graph didn't depict the data as I hoped.
	 *
	 * @param   $data   Array data to be viewed on the line graph.
	 * @return  array;
	 */
	function getGoogleLineGraphFormat( $data ) {

		//sorry, hard-coding it because I can't get my head around it otherwise

		//Chrismtas dates
		$day2 = 20121221;
		$day3 = 20121222;
		$day4 = 20121223;
		$day5 = 20121224;
		$day6 = 20121225;
		$day7 = 20121226;
		$day8 = 20121227;
		$day9 = 20121228;
		$day10 = 20121229;
		$day11 = 20121230;

		$day2Tweets = array();
		$day3Tweets = array();
		$day4Tweets = array();
		$day5Tweets = array();
		$day6Tweets = array();
		$day7Tweets = array();
		$day8Tweets = array();
		$day9Tweets = array();
		$day10Tweets = array();
		$day11Tweets = array();

	

		foreach( $data as $tweet ) {

			$time = $tweet->created_at;
			$day = substr( $time, 0, 10 );
			$explode_day = explode( "-", $day );
			$implode_day = implode( '', $explode_day );
			$implode_day = intval( $implode_day );

			//So I'm just checking which date the tweet belongs to, then shoving it into that date's array
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
			if ( $implode_day == $day10 ) {
				$day8Tweets[] = $tweet;
			}
			if ( $implode_day == $day11 ) {
				$day9Tweets[] = $tweet;
			}
			
		}
		
		$days = array();
		$days = array( 'day2' => array( $day2 => $day2Tweets ), 'day3' => array( $day3 => $day3Tweets ),
				  'day4' => array( $day4 => $day4Tweets ), 'day5' => array( $day5 => $day5Tweets ), 'day6' => array( $day6 => $day6Tweets ),
				  'day7' => array( $day7 => $day7Tweets ),
				  'day8' => array( $day8 => $day8Tweets ),
				  'day9' => array( $day9 => $day9Tweets ),
				  'day10' => array( $day10 => $day10Tweets ),
				  'day11' => array( $day11 => $day11Tweets ));

		
		// DATA NORMALISATION for the line graph
		// http://sonia.hubpages.com/hub/stddev
		$sentiment = array();
		$means = array();
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
			$means[] = $sentiment_mean;


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
		//unset ( $normalised_sentiment[ 0 ] );

		return $normalised_sentiment;
		//return $means;

	}

	/**
	 * Finds the average sentiment per city.
	 * It's used in the Bubble graph.
	 *
	 * @param   $happiest_cities   Array containing all cities
	 * @return  array
	 */
	function getAverageSentimentPerCity( $happiest_cities ) {

		$cities = array();
		$output = array();
		$frequency = 1;
		$count = 0;

		$cities_string = '

					 Bath	 Birmingham	 Bradford
					 Brighton and Hove	 Bristol	 Cambridge
					 Canterbury	 Carlisle	 Chester
					 Chichester	 Coventry	 Derby
					 Durham	 Ely	 Exeter
					 Gloucester	 Hereford	 Kingston upon Hull
					 Lancaster	 Leeds	 Leicester
					 Lichfield	 Lincoln	 Liverpool
					 City of London	 Manchester	 Newcastle upon Tyne
					 Norwich	 Nottingham	 Oxford
					 Peterborough	 Plymouth	 Portsmouth
					 Preston	 Ripon	 Salford
					 Salisbury	 Sheffield	 Southampton
					 St Albans	 Stoke-on-Trent	 Sunderland
					 Truro	 Wakefield	 Wells
					 Westminster	 Winchester	 Wolverhampton
					 Worcester	 York

					 Bangor	 Cardiff	 Newport
					 St Davids	 Swansea

					 Aberdeen	 Dundee	 Edinburgh
					 Glasgow	 Inverness	 Stirling

					 Armagh	 Belfast	 Londonderry
					 Lisburn	 Newry

					';

		if ( !empty( $happiest_cities ) ) {


			foreach ( $happiest_cities as $happiest_city ) {

				$city = $happiest_city->city;
				$sentiment = $happiest_city->sentiment;

				//Check if the city is not empty
				if ( !empty( $city ) && $city != null ) {

					$city = $happiest_city->city;

						//Check if city name is within the list of cities (above)
						//so you don't get the towns, which Geocoder picks up as 'cities'
						if (strstr($cities_string, $city)) {

							$frequency++;
							$cities[] = array ('name' => $city, 'sentiment' => $sentiment, 'tweet' => $happiest_city->tweet_text);

						}

				}

			}
			
			$output = array();
			$counts = array();

			foreach ($cities as $key=>$subarr) {
			
			  // Add to the current group count if it exists
			  if (isset($counts[$subarr['name']])) {
				$counts[$subarr['name']]++;
			  }
			  // or initialize to 1 if it doesn't exist
			  else $counts[$subarr['name']] = 1;

			  // Or the ternary one-liner version
			  // instead of the preceding if/else block
			  $counts[$subarr['name']] = isset($counts[$subarr['name']]) ? $counts[$subarr['name']]++ : 1;
			}

			$sentiment = 0;
			$frequency = 0;
			$new_array = array();
			$names_and_tweets = array();

			//A fallback for servers not using PHP 5.4
			if (!defined('ENT_SUBSTITUTE')) {
				define('ENT_SUBSTITUTE', 8);
			}

			//Construct a new array with City names and their tweets
			foreach ($cities as $city) {
				
				//count how many times the city name appears in the array
				$city['tweet'] = utf8_encode(htmlspecialchars( $city['tweet'], ENT_SUBSTITUTE ));
				
				$names_and_tweets[] = array( $city['name'] => $city['tweet'] );
			
			}

			//Using the City names and tweets, construct a new array with the city's sentiment and one random tweet
			foreach ( $cities as $city ) {
			
				$tweets = array();
				foreach ( $names_and_tweets as $name_and_tweet ) {

					//Checks if the city field is set within the array
					if ( isset( $name_and_tweet[$city['name']] )) {

						//Constructs a new array with just the tweets for that city
						$tweets[] =  $name_and_tweet[$city['name']];

					}

				}

				//Again checks if city is within the listed cities above; if the city is a major city
				if ( strstr($cities_string, $city['name']) ) {

					//store the city name and all of its tweets so you can access them later
					$cities_tweets[] = array( $city['name'] => $tweets );
					
				}

				//Count how many tweets are within the array 
				$quan = count($tweets) -1;

				//If there are more than one tweet, get a random one
				if ( $quan > 1 ) {

					//Generate a random number between zero and the total amount of tweets
					$index = rand( 0, $quan );

					//Get the tweet with this random index
					$random_tweet = $tweets[$index];

					//Restore the city array's tweet index with the value of this 1 random tweet
					$city['tweet'] = $random_tweet;
					
				}

				// If there is only one tweet, just construct the city array's "tweet" index with the first tweet
				else $city['tweet'] = $tweets[0];

				//taken from http://board.phpbuilder.com/showthread.php?10388043-How-To-Pick-Out-Array-Values-amp-Sum-Them&p=11019071#post11019071
				//Construct a new array that within its key as the city name, it holds the city's sentiment and tweet
				$new_array[$city['name']] = array(floatval($city['sentiment']), $city['tweet']);

			}
			

			//Use this new array to average out the city's sentimental value
			foreach ($new_array as $k => $v) {
		
				$division = count($v);
				$average = array_sum($v)/$division;

				//Store the averaged
				//I did have some code here to store it but it looks like I deleted it :(

				//Create the final array tha just formats data into particular keys
				$output[] = array('name' => $k, 'sentiment' => $v[0], 'tweet' => $v[1]);
				
			}

			$data = array();

			//Convert the $output array into a JSONstring for easier reading in the View.
			$data['json'] = json_encode($output);

			//Just lists the cities and their tweets for the Cities Sample Tweets data visualisation.
			$data['cities_tweets'] = $cities_tweets;
			 
			return $data;

		}
	
	}

	/**
	 * Creates and/or writes to a JSON file in the /assets/json directory
	 * Used by the D3 library when reading data easily more efficiently than generating it by PHP on every call
	 *
	 * @param  $JSON       The JSONstring of data
	 * @param  $fileName   The name of the file written to
	 * @return boolean
	 */
	function writeJSONFile( $JSON, $fileName ) {

		if ( isset( $JSON ) && isset( $fileName ) ) {

			file_put_contents( dirname( __FILE__ ) . '/../assets/json/'. $fileName . '.json', $JSON);

			return true;
		}


	}

	/**
	 * Uses Dictionary.com's API to pull in slang definitions of words.
	 * [Not active in application]
	 * I never actually received the API key that I requested to use this API. So, I couldn't get the slang definitions.
	 *
	 * @param   $word         A string, the slang word
	 * @return  $definition   
	 */
	function getSlangSentiment( $word ) {

		//http://developer.dictionary.com/account/apikeys
		$apikey = "t0851pyartj4wzhzbe643jabzsbrm04f1cl21jcsdv";
		$definition = file_get_contents("http://api-pub.dictionary.com/v001?vid=$apikey&q=hey&type=define&site=slang");

		return $definition;
	}

	/**
	 * Applies patterns into methods from the Linear Regression methodology
	 *
	 * @param   $tweet   The singular tweet to be refined
	 * @return  integer
	 */
	function refineTweet( $tweet ) {

		$bad = false;
		$value = 1;
		$tweet = $tweet->tweet_text;

		//Grabbing laughter from tweets and returning a high sentiment value
		if ( strstr($tweet, 'hehe' ) || strstr($tweet, ' ha ') || strstr($tweet, 'haha')  || strstr($tweet, ' lol ') ||
			strstr($tweet, ' lmao ')  || strstr($tweet, ' rofl ') || strstr($tweet, ' haa ') || strstr($tweet, ' :) ') ||
			strstr($tweet, 'laughing out loud') ) {

			$value = 1.5;

		}

		// -- I will be also stating which values I've changed from the ANEW dataset --

		//I changed 'hate' to have a value of 1 in the ANEW dataset | from 2.12
		//I changed 'dead' to have a vlaue of 0 in the ANEW dataset | from 1.94

		//If the tweet has the phrase, "in a good way", return a higher sentiment value;
		if ( strstr($tweet, 'in a good way') ) {
			$value = 1.5;
		}

		//if the sentence contains the word, "die" then give the sentiment a lower sentiment value;
		if ( strstr($tweet, ' die ') || strstr($tweet, ' died ')) {
			$value = .5;
			$bad = true;
		}

		#if the tweet contains, "is best", give it a higher sentiment;
		if ( strstr($tweet, 'is best')) {
			$value = 1.5;
		}

		//superheros sourced http://en.wikipedia.org/wiki/List_of_superheroes_and_villains_without_superpowers
		if ( $match = strstr($tweet, strtolower('i am') || $match = strstr($tweet, strtolower('i\'m') )) ) {
			
			$superheros_file    = file_get_contents(dirname(__FILE__) . '/../anew_2010/superheros.txt');
			$rows = explode( "\n", $superheros_file );
			$superheros = $rows;

			$words = array();
			$words = explode(' ', $match);

			foreach ( $superheros as $superhero ) {
				if ($words[2] == $superhero) {
					
					$value = 1.5;
					
				}
			}

		}

		//increasing sentiment in relation to recreational drug use
		if ( strstr($tweet, 'got high')) {
			$value =  1.5;
		}

		//increase sentiment if mention of "time of my life"
		if ( strstr($tweet, 'time of my life') ) {
			$value = 1.5;
		}

		//increase sentiment if having time off work
		if ( strstr($tweet, 'stay off') || strstr($tweet, 'time off') ) {
			$value = 1.5;
		}

		//hangover
		if ( strstr($tweet, 'hangover') ) {
			$value = 0.5;
			$bad = true;
		}

		//ill
		if ( strtolower(strstr($tweet, 'I don\'t feel well')) || strtolower(strstr($tweet, 'I dont feel well')) ) {
			$value = 0.5;
			$bad = true;
		}

		//gossip about tv show - http://www.imdb.com/search/title?countries=gb&sort=moviemeter&title_type=tv_series
		$tvshows_file    = file_get_contents(dirname(__FILE__) . '/../anew_2010/tvshows.txt');
		$rows = explode( "\n", $tvshows_file );
		$soap_operas = $rows;

		$words = array();
		$words = explode(' ', $match);

		//Increase the sentiment slightly because the person is likely to be acting cheaky and therefore slightly cheerful
		foreach ( $soap_operas as $soap ) {

			strtolower($soap);

			if (strstr($tweet, " $soap ")) {
				$value = 1.2;
			}

		}

		//calory counting - guilt - shame
		if ( strstr($tweet, ' calories ')) {
			$value = 0.5;
			$bad = true;
		}

		//if a tweet contains 'cut' but precedes with the word 'hair', increase the overal tweet sentiment by half
		if ( strstr($tweet, ' hair cut ')) {
			$value = 1.5;
			$bad = true;
		}

		//enjoyment of food/drink
		if ( strstr($tweet, ' full fat ')) {
			$value = 1.5;
		}
		
		//Smiley face
		if (strstr($tweet, ' :) ')) {
			$value = 1.5;
		}

		//Sad face
		if (strstr($tweet, ' :( ')) {
			$value = 0.5;
			$bad = true;
		}

		//slang = stonker
		if (strstr($tweet, ' stonker ')) {
			$value = 1.5;
			if ( $bad ) {
				$value = 0.7;
			}
		}

		//kiss
		if ( strstr($tweet, 'xx') || strstr($tweet, ' x ')) {
			$value = 1.5;
			if ( $bad ) {
				$value = 0.7;
			}
		}

		//boo (theatre boo)
		if ( strstr($tweet, ' boo ')) {
			$value = 0.7;
		}

		//mentioning a murder
		if ( strtolower(strstr($tweet, ' i\'ll kill ')) || strtolower(strstr($tweet, 'ill kill')) || strtolower(strstr($tweet, 'i will kill')) ) {
			$value = 0.3;
		}

		//Empathy for bad joke
		if ( strtolower(strstr($tweet, 'i\'m joking') || strtolower(strstr($tweet, 'i am joking')) || strtolower (strstr($tweet, 'im joking')) )) {
			$value = 0.9;
		}

		//Sympathy
		if ( strtolower(strstr($tweet, 'don\'t worry about it')) || strtolower(strstr($tweet, ' dont worry '))) {
			$value = 0.8;
		}

		//Given 'shock' a value of 2 from 4.03
		if ( strtolower(strstr($tweet, 'shocking'))) {
			$value = 0.5;
		}

		//self pitty
		if ( strtolower(strstr($tweet, 'i\m fat')) || strtolower(strstr($tweet, 'i am fat')) || strtolower(strstr($tweet, 'im fat'))) {
			$value = 0.5;
		}

		//Note 'fat' added more sentiment in ANEW dataset - from 2.28 to 4

		//excitement
		if ( strstr($tweet, ' too excited ')) {
			$value = 1.5;
		}

		//more murder
		if ( strtolower(strstr($tweet, 'cut your head off'))) {
			$value = 0.3;
		}

		//sarcasm, frustration
		if ( strstr($tweet, 'merry fucking christmas') || strstr($tweet, 'merry shitty christmas') || strstr($tweet, 'merry fuckin christmas')) {
			$value = 0.3;
		}

		//acknowledgement
		if ( strstr($tweet, ' not bad ') ) {
			$value = 1.5;
		}

		//angry
		if ( strstr($tweet, ' fuckers ') ) {
			$value = 0.5;
		}

		//hell given a higher sentiment of 4 from 2.24

		return $value;

	}

}
?>
