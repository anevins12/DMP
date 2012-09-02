<?php

class Tweetsmodel {

	protected $tableName = "tweets";

	function __construct(){
		include_once('../config/database.php');
	}

	public function getAllTweets( $order = NULL, $limit = NULL ) {
		
		$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
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

}


?>
