<?php

// Supressed notices about already defined HOSTNAME, USERNAME, PASSWORD, DATABASE
@define('HOSTNAME'    ,    'localhost');
@define('USERNAME'    ,    'root');
@define('PASSWORD'    ,    '');
@define('DATABASE'    ,    'twitter');

//UWE SERVERS

if ( $_SERVER['HTTP_HOST'] != 'localhost' ) {

	@define('HOSTNAME'    ,    'mysql');
	@define('USERNAME'    ,    'fet09019549');
	@define('PASSWORD'    ,    '8wtXB8');
	@define('DATABASE'    ,    'a2-nevins');

}
?>
