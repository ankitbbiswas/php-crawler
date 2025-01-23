<?php

function isCrawlable($url) {
    $variations = [
        $url,
        "https://$url",
        "http://$url",
        "https://www.$url",
        "http://www.$url"
    ];

    foreach ($variations as $variant) {
        $code = getHttpCode($variant);
        if ($code == 200) {
            return 'CRAWLABLE';
        }
    }

    return 'NOT CRAWLABLE';
}

function getHttpCode($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $code ?: 'Error';
}
