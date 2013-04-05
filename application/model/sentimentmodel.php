<?php
/**
 * Gets and Inserts sentimental values in the 'sentiment' table
 *
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 * @package My work
 */
class sentimentmodel {

	protected $tableName = 'sentiment';

	function __construct() {
		include( dirname(__FILE__) . '/../config/database.php' );
	}

	/**
	 * Insert sentiment into one row of the 'sentiment' table
	 *
	 * @param   $tweet_id          To identify the tweet associated with the sentiment
	 * @param   $sentiment_value   Integer, but may be double. Ranges from 0 to 10.
	 * @return  boolean
	 */
	public function insertSentiment( $tweet_id, $sentiment_value ) {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {

			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

		}

		$query = "INSERT INTO $this->tableName (tweet_id, sentiment_value) VALUES ($tweet_id, $sentiment_value)";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			return true;

		}

		else {

			return false;

		}

	}

	/**
	 * Gets all tweets' sentimental vale
	 * Was used when there was a separate table for sentimental values.
	 * [Not active in application]
	 *
	 * @return  array | boolean
	 */
	public function getTweetsSentiment () {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {

			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

		}

		$query = "SELECT * FROM $this->tableName, tweets WHERE $this->tableName.tweet_id = tweets.tweet_id";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

		}

		else {

			return false;

		}

		return $allTweets;
	}

}

?>
