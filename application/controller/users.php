<?php
/**
 * Description of tweets
 *
 * @author andrew
 */

class Users {

    function __construct() {
		include_once ( dirname(__FILE__) . '/../model/usersmodel.php' );
	}

	function getAllUsers() {
		$users = new Usersmodel();
		$allUsers = $users->getAllUsers();

		return json_encode($allUsers);
	}

}