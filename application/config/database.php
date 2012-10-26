<?php

//UWE SERVERS
if ( strstr( @$_SERVER['HTTP_HOST'], 'cems.uwe' ) ) {

	define('HOSTNAME'    ,    'mysql5');
	define('USERNAME'    ,    'fet09019549');
	define('PASSWORD'    ,    '8wtXB8');
	define('DATABASE'    ,    'fet09019549');

}

//PERSONAL MACHINE
if ( strstr ( @$_SERVER['HTTP_HOST'], 'localhost' ) ) {
 
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'root');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'twitter');

}

//byethost
else {

    define('HOSTNAME'    ,    'sql105.byethost24.com');
    define('USERNAME'    ,    'b24_11634984');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'b24_11634984_twitter');

}

?>
