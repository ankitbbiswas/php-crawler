<?php

function sanitizeFileName($url) {
    // Remove http:// or https:// from the URL
    $url = preg_replace("#^https?://#", "", $url);
    
    // Replace "/" with "_" if it exists
    if (strpos($url, "/") !== false) {
        $url = str_replace("/", "_", $url);
    }
    
    // Replace other characters with '-'
    $url = preg_replace("/[^a-zA-Z0-9\.\-_]/", "-", $url);
    
    // Remove duplicate '-' characters
    $url = preg_replace("/-+/", "-", $url);
    
    return $url;
}

?>