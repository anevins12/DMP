<?php

/**
 * This class retrieves and updates data from the 'tweets' table of the database.
 *
 * It doesn't do enough manipulating of data. The 'tweets' controller does this - Bad, I know.
 * Unfortunately, the tweets controller tries to play God. 
 *
 * 
 * @author_name Andrew Nevins
 * @author_no 09019549
 */
class Tweetsmodel {

	protected $tableName = "tweets";

	function __construct(){
		include_once( dirname(__FILE__) . '/../config/database.php' );
	}

	/**
	 * Gets a sample of the most recent tweets 
	 *
	 * @return array
	 */
	public function getRecentTweets() {
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Get 10 tweets that follow the general feeling rules and that are the most recent
		$query = "SELECT * FROM $this->tableName
				  WHERE `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i feel%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i am feeling%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i\'m feeling%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i dont feel%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i\'m%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%im%'
		          OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i am%'
			 	  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%makes me%'
				  ORDER BY `created_at` DESC LIMIT 0, 10";

		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweets Retrieved.';
		}

		return $allTweets ;
	}

	/**
	 * Retrieves all tweets
	 *
	 * @param  $order  To order the SQL returned data
	 * @param  $limit  To limit the SQL returned data
	 * @return array
	 */
	public function getTweets( $order = NULL, $limit = NULL ) {
		
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Get all tweets that follow the feeling rules
		$query = "SELECT * FROM $this->tableName WHERE `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i feel%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i am feeling%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i\'m feeling%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i dont feel%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I\'m%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%Im%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I am%'
					OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%makes me%'  "
					. ( $order ? " ORDER BY $order" : "" ) . ( $limit? " LIMIT $limit" : "" );
		
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweets Retrieved.';
		}
		
		return $allTweets ;

	}

	/**
	 * Gets the tags associated to sad tweets
	 *
	 * @return JSONobject
	 */
	public function getSadTweetTags() {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Get all tags from tweet_tags table where the tweet_id is the same as the tweets table.
		//Where sentiment is not equal to zero
		//Where sentiment is less than 1.5
		//Return disctinct rows.
		$query = "SELECT DISTINCT * FROM $this->tableName
				INNER JOIN tweet_tags
				ON tweets.tweet_id = tweet_tags.tweet_id
				WHERE `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i feel%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i am feeling%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i\'m feeling%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i dont feel%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I\'m%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%Im%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I am%'
				OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%makes me%'
				LIMIT 20";

		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweets Retrieved.';
		}

		$tags = array();

		foreach ( $allTweets as $tweet ) {

			$tags[] = array('word' => $tweet->tag, 'sentiment' => $tweet->sentiment);

		}	

		//Put data into an array with particular Keys and Values because am accessing this from API.
		//The array is converted to JSON - JSON will generate the webpage for the data.
		$tags = json_encode($tags);
		return $tags;

	}
	
	/**
	 * Gets the tags associated to happy tweets
	 *
	 * @return JSONobject
	 */
	public function getHappyTweetTags() {
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Get all tags from tweet_tags table where the tweet_id is the same as the tweets table.
		//Where sentiment is not equal to zero.
		//Where sentiment is greater than 5.
		//Return disctinct rows.
		$query = "SELECT DISTINCT * FROM $this->tableName
				INNER JOIN tweet_tags
				ON tweets.tweet_id = tweet_tags.tweet_id
				WHERE `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i feel%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i am feeling%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i\'m feeling%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i dont feel%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I\'m%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%Im%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I am%'
				OR `sentiment` > 5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%makes me%'
				LIMIT 20";

		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweets Retrieved.';
		}

		$tags = array();

		//sorting particular keys and relative values into an array
		foreach ( $allTweets as $tweet ) {

			$tags[] = array('word' => $tweet->tag, 'sentiment' => $tweet->sentiment);

		}

		//array to be converted to JSON
		//read by API
		$tags = json_encode($tags);
		return $tags;

	}

	/**
	 * Gets one row of data from a matched tweet_id
	 *
	 * @param  $tweet_id The actual tweet_id to match in the database table
	 * @return array
	 */
	public function getTweet( $tweet_id ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Gets tweet by tweet_id
		$query = "SELECT * FROM $this->tableName WHERE tweet_id = $tweet_id ";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$tweet[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweet Retrieved.';
		}

		return $tweet ;

	}

	/**
	 * Inserts a city into a tweet's table row
	 *
	 * @param  $tweet_id  The tweet's id to identify the database row
	 * @param  $city      The city to be inserted to that tweet
	 * @return true | string
	 */
	public function insertTweetCity ( $tweet_id, $city ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Update the city column's value with the passed city, for a particular tweet
		$query = "UPDATE $this->tableName SET city = '" . $city . "' WHERE tweet_id = $tweet_id";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}

		else {
			return $error .= "Failed to insert.";
		}
			
	}

	/**
	 * Inserts a sentimental value to the tweet's table row
	 *
	 * @param  $tweet       A tweet object that must hold a tweet_id
	 * @param  $sentiment   The sentimental value (usually from 0 - 10) to be associated with that tweet
	 * @return true | string
	 */
	public function setSentiment( $tweet, $sentiment ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//For a particular tweet, update the sentiment column's value with the passed sentiment value
		$query = "UPDATE $this->tableName SET sentiment = '" . $sentiment . "' WHERE tweet_id = '$tweet->tweet_id'";
		
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}

		else {
			return $error .= "Failed to insert.";
		}

	}

	/**
	 * Gets all cities where the sentiment is not zero
	 * Doesn't actually get the 'happiest' cities. The name of this function was in relation to the application's original intent.
	 *
	 * @return array | string
	 */
	public function getHappiestCities( ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Get cities and their relative sentimental values where sentiment is not zero.
		$query = "SELECT city, sentiment FROM $this->tableName WHERE city != '' AND sentiment !=0 ";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {
			return $error .= '\n No Tweet Retrieved.';
		}

		return $allTweets ;

	}

}


?>
