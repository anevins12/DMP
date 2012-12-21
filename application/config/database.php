<?php

//UWE SERVERS

if ( strstr( $_SERVER['HTTP_HOST'], 'andrewnevins.co.uk' ) ) {

	define('HOSTNAME'    ,    'maggie');
	define('USERNAME'    ,    'andrewne_dmp');
	define('PASSWORD'    ,    '*');
	define('DATABASE'    ,    'andrewne_dmp');

}

else {

    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'root');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'twitter');

}
?>
