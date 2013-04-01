<?php

/**
 * Gets data from the 'countries' table.
 * [Not active in application]
 * The aim was to associate tweets' geolocations with a set of coordinates in the 'countries' table and associated country name.
 * Was scrapped to be replaced with the Geocoder API service
 * 
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 */
class Locationsmodel {

	protected $tableName = "countries";

	function __construct() {
		include ( dirname(__FILE__) . '/../config/database.php' );
	}

	/**
	 * Gets the country from the 'countries' table, by country_id
	 *
	 * @param  $country_id   The actual ID of the country to be matched in the database table
	 * @return array | string
	 */
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

	/**
	 * Gets all countries from the countries table
	 *
	 * @param  $order   To order the data returned from the SQL statement
	 * @param  $limit   To limit the data returned
	 * @return array | string
	 */
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
