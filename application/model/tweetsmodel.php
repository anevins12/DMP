<?php

class Tweetsmodel {

	protected $tableName = "tweets";

	function __construct(){
		include_once( dirname(__FILE__) . '/../config/database.php' );
	}

	public function getTweets( $order = NULL, $limit = NULL ) {
		
		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		//Just retrieve the rows that have sentiment and location values  ---WHERE `sentiment` != '0' ".
		$query = "SELECT * FROM $this->tableName WHERE `sentiment` != '0' ". ( $order ? " ORDER BY $order" : "" ) . ( $limit? " LIMIT $limit" : "" );
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
