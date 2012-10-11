<?php

class Tweetsmodel {

	protected $tableName = "tweets";

	function __construct(){
		include_once('../config/database.php');
	}

	public function getTweets( $order = NULL, $limit = NULL ) {
		
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "SELECT * FROM $this->tableName" . ( $order ? " ORDER BY $order" : "" ) . ( $limit? " LIMIT $limit" : "" );
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

	public function insertTweetCountryCode( $tweet_id, $country_code ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "UPDATE $this->tableName SET country_code = '" . $country_code . "' WHERE tweet_id = $tweet_id ";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}

		else {
			return $error .= "Failed to insert.";
		}

	}

	public function set140Sentiment( $sentiment_id, $tweet_text ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "UPDATE $this->tableName SET sentiment_id = '" . $sentiment_id . "' WHERE tweet_text = '$tweet_text'";
		
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {
			return true;
		}

		else {
			return $error .= "Failed to insert.";
		}

	}

}


?>
