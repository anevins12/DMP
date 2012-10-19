<?php
/**
* get_tweets.php
* Collect tweets from the Twitter streaming API
* This must be run as a continuous background process
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/

require_once('./140dev_config.php');

// Extend the Phirehose class to capture tweets in the json_cache MySQL table
require_once(  dirname(__FILE__) . '/../libraries/phirehose/phirehose.php');
class Consumer extends Phirehose
{
  // A database connection is established at launch and kept open permanently
  public $oDB;
  public function db_connect() {
    require_once('./db_lib.php');
    $this->oDB = new db;
  }
	
  // This function is called automatically by the Phirehose class
  // when a new tweet is received with the JSON data in $status
  public function enqueueStatus($status) {
  require_once('./db_lib.php');
    $tweet_object = json_decode($status);

	//Supresses undefined property notices
	$tweet_id = @$tweet_object->id_str;

    // If there's a ", ', :, or ; in object elements, serialize() gets corrupted 
    // You should also use base64_encode() before saving this
    $raw_tweet = base64_encode(serialize($tweet_object));
		
    $field_values = 'raw_tweet = "' . $raw_tweet . '", ' .
      'tweet_id = ' . $tweet_id;

	// grab the coordinates to check later
	if (@$tweet_object->geo) {

		$coordinates = $tweet_object->coordinates->coordinates;

		$geo_lat = $coordinates[1];
		$geo_long = $coordinates[0];
	}
	else {
		$geo_lat = 0;
		$geo_long = 0;
	}
        
	// check if object && check if tweet from UK
	if ( $tweet_object && ( $this->oDB->isUKTweet( $geo_lat, $geo_long ) ) ) {
		$this->oDB->insert('json_cache',$field_values);
	}
  }
}

// Open a persistent connection to the Twitter streaming API
// Basic authentication (screen_name, password) is still used by this API
$stream = new Consumer(STREAM_ACCOUNT, STREAM_PASSWORD);

// Establish a MySQL database connection
$stream->db_connect();

// The keywords for tweet collection are entered here as an array
// More keywords can be added as array elements
// For example: array('recipe','food','cook','restaurant','great meal')
//$searchWords = array( "better", "bad", "good", "right", "guilty", "sick", "same", "sorry",  "well", "down" );
//$searchPrefixes = array( "I'm feeling", "I am feeling", "I feel" );
//
//$trackWords = array();
//
//foreach ( $searchWords as $searchWord ) {
//
//	foreach ( $searchPrefixes as $searchPrefix ) {
//		$trackWords[] = $searchPrefix . ' ' . $searchWord;
//	}
//
//}

//$stream->setTrack(array(''));

// Start collecting tweets
// Automatically call enqueueStatus($status) with each tweet's JSON data

 $stream->consume();




?>