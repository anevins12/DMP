<?php

if ($GLOBALS['_SERVER']['HTTP_HOST'] !== 'dmp') {
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    '****');
    define('PASSWORD'    ,    '****');
    define('DATABASE'    ,    '****');
}
else {
    define('HOSTNAME'    ,    'localhost');
    define('USERNAME'    ,    'root');
    define('PASSWORD'    ,    '');
    define('DATABASE'    ,    'twitter');
}


?>
