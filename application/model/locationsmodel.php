<?php

class Locationsmodel {

	protected $tableName = "countries";

	function __construct() {
		include ( dirname(__FILE__) . '/../config/database.php' );
	}

	public function getCountry( $country_id ) {

		$error = "";

		$query = "SELECT * FROM $this->tableName WHERE id = $country_id" . ( $limit ? " LIMIT $limit" : "" );
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ){
					$allTweets[] = $row;
			}

			return $allTweets;

		}

		else {

			return $error .= '\n No Country found.';

		}

	}

	public function getCountries( $order = NULL, $limit = NULL ) {

		$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
		$error = '';

		if ( $mysqli->connect_errno ) {

			$error = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

		}

		$query = "SELECT * FROM $this->tableName" . ( $order ? " ORDER BY $order" : "" ) . ( $limit? " LIMIT $limit" : "" );
		$result = $mysqli->query( $query, MYSQLI_USE_RESULT );

		if ( $result ) {

			while ( $row = $result->fetch_object() ) {
					$allCountries[] = $row;
			}

		}

		else {

			return $error .= '\n No Tweets Retrieved.';

		}

		return $allCountries ;

	}

}

?>
