<?php

 // Initialize curl
class utility{
    
    function passUWEProxy() {
        $ch = curl_init();
        
        // Set the options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');  // Required by API
        curl_setopt($ch, CURLOPT_USERAGENT, self::$user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        //proxy if running at UWE
        curl_setopt($ch, CURLOPT_PROXY, "http://proxysg.uwe.ac.uk:8080");
        curl_setopt($ch, CURLOPT_PROXYPORT, 8080); 

        // Get the data returned by the method and close our handle
        $data = curl_exec($ch);
    }
}
        
?>
