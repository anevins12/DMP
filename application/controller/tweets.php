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
		
		$AverageTweetsJSON = $this->getAverageSentimentPerCity($tweets);
		
		$this->writeJSONFile($AverageTweetsJSON, 'christmas-cities-13-02-2013');
//		$this->writeJSONFile($AverageTweetsJSON, 'cities-towns-average-tweets-quantity');

		//set the sentiment values
//		foreach ($tweets as $tweet){
//			$this->getANEWSentiment($tweet);
//		}
		
		//$this->setLocations($tweets);

		return $AverageTweetsJSON;

	}

	public function getTweetTags() {
		$tweetsmodel = new Tweetsmodel;
		$tags= $tweetsmodel->getTweetTags();
	
		$this->writeJSONFile($tags, 'tweetTags');
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
//		$tweet_text = "@saoirsef24 haha....good one! Not if I'm feeling like this now! #FeelLikeShite";
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
		//CHRISTMAS

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

		//now you can normalise the data for each day
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
		$temp_city = '';

		if ( !empty( $happiest_cities ) ) {

			//sort the array by sentiment ascending
			//inspired by a comment on http://php.net/manual/en/function.array-multisort.php
			foreach ( $happiest_cities as $k => $row ) {
					$happiest_citiesSort[ $k ]  = $row->sentiment;
			}
			array_multisort( $happiest_citiesSort, SORT_ASC, $happiest_cities );

			foreach ( $happiest_cities as $happiest_city ) {

				$city = $happiest_city->city;
				$sentiment = $happiest_city->sentiment;

				if ( !empty( $city ) && $city != null ) {

					$city = $happiest_city->city;

						//check if city name is within the list of cities (above)
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

			foreach ($cities as $city) {
				//count how many times the city name appears in the array
				$names_and_tweets[] = array( $city['name'] => $city['tweet'] );
				
			}
			foreach ($cities as $city) {

				$tweets = array();
				foreach ($names_and_tweets as $name_and_tweet) {

					if ( isset( $name_and_tweet[$city['name']] )) {
						$tweets[] = $name_and_tweet[$city['name']];
					}

				}
				
				$quan = count($tweets) -1;
				if ( $quan > 1 ) {
					$index = rand( 0, $quan );
					$random_tweet = $tweets[$index];
					$city['tweet'] = $random_tweet;
				}
				else $city['tweet'] = $tweets[0];
				
				$temp_city = $city['name'];

				//taken from http://board.phpbuilder.com/showthread.php?10388043-How-To-Pick-Out-Array-Values-amp-Sum-Them&p=11019071#post11019071
				$new_array[$city['name']] = array(floatval($city['sentiment']), $city['tweet']);

			}
			//construct new array
			foreach ($new_array as $k => $v) {
			
				$division = count($v);
				$average = array_sum($v)/$division;

				$output[] = array('name' => $k, 'sentiment' => $v[0], 'tweet' => $v[1]);
			}
			
			$output = array( $output );		
			$output = json_encode($output);

			$array_of_objects = json_decode($output);
			$object = $array_of_objects[0];
			$output = json_encode($object);

			return $output;

		}
	
	}

	/*Specifying JSON because JSON should be the only input to write to the file */
	function writeJSONFile( $JSON, $fileName ) {

		if ( isset( $JSON ) && isset( $fileName ) ) {

		 file_put_contents( dirname( __FILE__ ) . '/../assets/json/'. $fileName . '.json', $JSON);
			
		}


	}

	function getSlangSentiment( $word ) {

		//http://developer.dictionary.com/account/apikeys
		$apikey = "t0851pyartj4wzhzbe643jabzsbrm04f1cl21jcsdv";
		$definition = file_get_contents("http://api-pub.dictionary.com/v001?vid=$apikey&q=hey&type=define&site=slang");

		var_dump($definition);exit;
	}

# refineTweet function
# returns integer
# returned values reflect the amount of increasement / decreasement to multiply the tweet entire tweet against (after sentiment analysis per each word)
#
# Need to figure out a way to decrease/increase the sentiment of tweets, still within the range of 0 - 9,
# that reflects certain words, characters or phrases in a tweet.
	function refineTweet( $tweet ) {

		$bad = false;

		$tweet = $tweet->tweet_text;


		#Grabbing laughter from tweets and returning a high sentiment value
		if ( strstr($tweet, 'hehe' ) || strstr($tweet, ' ha ') || strstr($tweet, 'haha')  || strstr($tweet, ' lol ') ||
			strstr($tweet, ' lmao ')  || strstr($tweet, ' rofl ') || strstr($tweet, ' haa ') || strstr($tweet, ' :) ') ||
			strstr($tweet, 'laughing out loud') ) {

			$value = 1.5;

		}

		#I changed 'hate' to have a value of 1 in the ANEW dataset | from 2.12
		#I changed 'dead' to have a vlaue of 0 in the ANEW dataset | from 1.94

		#If the tweet has the phrase, "in a good way", return a higher sentiment value;

		if ( strstr($tweet, 'in a good way') ) {
			$value = 1.5;
		}

		#if the sentence contains the word, "die" then give the sentiment a lower sentiment value;
		if ( strstr($tweet, 'die') || strstr($tweet, 'died')) {
			$value = .5;
			$bad = true;
		}

		#if the tweet contains, "is best", give it a higher sentiment;
		if ( strstr($tweet, 'is best')) {
			$value = 1.5;
		}

		#superheros sourced http://en.wikipedia.org/wiki/List_of_superheroes_and_villains_without_superpowers
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

		#increasing sentiment in relation to recreational drug use
		if ( strstr($tweet, 'got high')) {
			$value =  1.5;
		}

		#increase sentiment if mention of "time of my life"
		if ( strstr($tweet, 'time of my life') ) {
			$value = 1.5;
		}

		#increase sentiment if having time off work
		if ( strstr($tweet, 'stay off') || strstr($tweet, 'time off') ) {
			$value = 1.5;
		}

		#hangover
		if ( strstr($tweet, 'hangover') ) {
			$value = 0.5;
			$bad = true;
		}

		#ill
		if ( strtolower(strstr($tweet, 'I don\'t feel well')) || strtolower(strstr($tweet, 'I dont feel well')) ) {
			$value = 0.5;
			$bad = true;
		}

		#gossip about tv show - http://www.imdb.com/search/title?countries=gb&sort=moviemeter&title_type=tv_series
		
		$tvshows_file    = file_get_contents(dirname(__FILE__) . '/../anew_2010/tvshows.txt');
		$rows = explode( "\n", $tvshows_file );
		$soap_operas = $rows;

		$words = array();
		$words = explode(' ', $match);

		foreach ( $soap_operas as $soap ) {

			strtolower($soap);

			if (strstr($tweet, " $soap ")) {
				$value = 1.2;
			}

		}

		#calory counting - guilt - shame
		if (strstr($tweet, 'full fat') || strstr($tweet, ' calories ')) {
			$value = 0.5;
			$bad = true;
		}

		#check uppercase - emphasis of word

		#Smiley face
		if (strstr($tweet, ' :) ')) {
			$value = 1.5;
		}

		#Sad face
		if (strstr($tweet, ' :( ')) {
			$value = 0.5;
			$bad = true;
		}

		#slang = stonker
		if (strstr($tweet, ' stonker ')) {
			$value = 1.5;
			if ( $bad ) {
				$value = 0.7;
			}
		}

		#kiss
		if ( strstr($tweet, 'xx') || strstr($tweet, ' x ')) {
			$value = 1.5;
			if ( $bad ) {
				$value = 0.7;
			}
		}


		#boo
		if ( strstr($tweet, ' boo ')) {
			$value = 0.7;
		}

		#mentioning a murder
		if ( strtolower(strstr($tweet, ' i\'ll kill ')) || strtolower(strstr($tweet, 'ill kill')) || strtolower(strstr($tweet, 'i will kill')) ) {
			$value = 0.3;
		}

		#Empathy for bad joke
		if ( strtolower(strstr($tweet, 'i\'m joking') || strtolower(strstr($tweet, 'i am joking')) || strtolower (strstr($tweet, 'im joking')) )) {
			$value = 0.9;
		}

		#Sympathy
		if ( strtolower(strstr($tweet, 'don\'t worry about it')) || strtolower(strstr($tweet, ' dont worry '))) {
			$value = 0.8;
		}

		#Given 'shock' a value of 2 from 4.03
		if ( strtolower(strstr($tweet, 'shocking'))) {
			$value = 0.5;
		}

		#self pitty
		if ( strtolower(strstr($tweet, 'i\m fat')) || strtolower(strstr($tweet, 'i am fat')) || strtolower(strstr($tweet, 'im fat'))) {
			$value = 0.5;
		}

		#excitement
		if ( strstr($tweet, ' too excited ')) {
			$value = 1.5;
		}

		#more murder
		if ( strtolower(strstr($tweet, 'cut your head off'))) {
			$value = 0.3;
		}

		if ( strstr($tweet, 'merry fucking christmas') || strstr($tweet, 'merry shitty christmas') || strstr($tweet, 'merry fuckin christmas')) {
			$value = 0.3;
		}

		#hell given a higher sentiment of 4 from 2.24

		return $value;

	}

}
?>
