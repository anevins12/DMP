<?php

/**
 * Grabs data from the Usersmodel and returns it
 *
 *
 * @author_name Andrew Nevins
 * @author_no 09019549
 */
class Users {

    function __construct() {
		include_once ( dirname(__FILE__) . '/../model/usersmodel.php' );
	}

	/**
	 * Gets all users (remember, it gets unhappy users) and convert it to a JSONstring
	 *
	 * @return  JSONstring
	 */
	function getAllUsers() {
		$users = new Usersmodel();
		$allUsers = $users->getAllUsers();

		return json_encode($allUsers);
	}

}