<?php

define('HOSTNAME'    ,    'localhost');
define('USERNAME'    ,    'root');
define('PASSWORD'    ,    '');
define('DATABASE'    ,    'twitter');

//UWE SERVERS
if ( strstr($_SERVER['HTTP_HOST'], 'isa' ) ) {

	define('HOSTNAME'    ,    'mysql5');
	define('USERNAME'    ,    'fet09019549');
	define('PASSWORD'    ,    '8wtXB8');
	define('DATABASE'    ,    'fet09019549');

}

?>
