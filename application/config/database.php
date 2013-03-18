<?php

if ($GLOBALS['_SERVER']['HTTP_HOST'] !== 'dmp') {
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'andrewne_2013');
    define('PASSWORD'    ,    'X84cU5tk4a');
    define('DATABASE'    ,    'andrewne_dmp');
}
else {
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'root');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'twitter');
}


?>
