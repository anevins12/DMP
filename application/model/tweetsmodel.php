<?php

class Tweetsmodel {

	protected $tableName = "tweets";

	function __construct(){
		include_once( dirname(__FILE__) . '/../config/database.php' );
	}

	public function getRecentTweets() {
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "SELECT * FROM $this->tableName
				  WHERE `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i feel%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i am feeling%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i\'m feeling%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i dont feel%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I\'m%'
				  OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%Im%'
		          OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I am%'
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

	public function getTweets( $order = NULL, $limit = NULL ) {
		
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		
		$query = "SELECT * FROM $this->tableName WHERE `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i feel%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i am feeling%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i\'m feeling%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%i dont feel%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I\'m%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%Im%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%I am%'
OR `sentiment` IS NOT NULL AND `tweet_text` LIKE '%makes me%'  ". ( $order ? " ORDER BY $order" : "" ) . ( $limit? " LIMIT $limit" : "" );
		
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

	public function getTweetTags() {
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

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

			$tags[] = array('word' => $tweet->tag, 'sentiment' => $tweet->sentiment, 'tweet' => $tweet->tweet_text);

		}	
		
		$tags = json_encode($tags);
		return $tags;

	}

	public function getTweet( $tweet_id ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "SELECT * FROM $this->tableName WHERE tweet_id = $tweet_id ";
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

	public function insertTweetCity ( $tweet_id, $city ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "UPDATE $this->tableName SET city = '" . $city . "' WHERE tweet_id = $tweet_id";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}
			
	}

	public function setSentiment( $tweet, $sentiment ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "UPDATE $this->tableName SET sentiment = '" . $sentiment . "' WHERE tweet_id = '$tweet->tweet_id'";
		
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}

		else {
			return $error .= "Failed to insert.";
		}

	}

	public function getHappiestCities( ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

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
