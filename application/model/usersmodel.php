<?php

class Usersmodel {

	protected $tableName = "users";

	function __construct(){
		include_once( dirname(__FILE__) . '/../config/database.php' );
	}

	public function getAllUsers() {

		$mysqli = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE );
		$error = '';

		if ( $mysqli->connect_errno ) {
			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$query = "SELECT DISTINCT * FROM $this->tableName
					INNER JOIN tweets
					ON tweets.user_id = $this->tableName.user_id
					WHERE `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i feel%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i am feeling%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i\'m feeling%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%i dont feel%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I\'m%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%Im%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%I am%'
					OR `sentiment` < 1.5 AND `sentiment` IS NOT NULL AND `sentiment` <> 0 AND `tweet_text` LIKE '%makes me%'";
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allUsers[] = $row;
			}

		}

		else {
			return $error .= '\n No Users Retrieved.';
		}

		return $allUsers;

	}

}

?>