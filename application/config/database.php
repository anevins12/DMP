<?php

//UWE SERVERS
if ( strstr( @$_SERVER['HTTP_HOST'], 'cems.uwe' ) ) {

	define('HOSTNAME'    ,    'mysql5');
	define('USERNAME'    ,    'fet09019549');
	define('PASSWORD'    ,    '');
	define('DATABASE'    ,    'fet09019549');

}

//PERSONAL MACHINE
// sometimes the HTTP_HOST variable doesn't exist so I've removed the conditional statement
// while working on localhost
// 
//if ( strstr ( @$_SERVER['HTTP_HOST'], 'localhost' ) ) {
//
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'root');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'twitter');

//}

//byethost
//else {
//
//    define('HOSTNAME'    ,    'sql105.byethost24.com');
//    define('USERNAME'    ,    'b24_11634984');
//    define('PASSWORD'    ,    '');
//    define('DATABASE'    ,    'b24_11634984_twitter');
//
//}

?>
