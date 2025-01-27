<?php

// Function to fetch source code and calculate string size in MB
function getStringSizeInMB($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout after 30 seconds
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Enable SSL host verification
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status code
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300 && !empty($response)) {
        // Calculate the size of the response directly
        $sizeInBytes = strlen($response);

        // Convert to MB (1 MB = 1024 * 1024 bytes)
        $sizeInMB = $sizeInBytes / (1024 * 1024);

        // Format to 2 decimal places and replace '.' with ',' for MB representation
        return number_format($sizeInMB, 2, ',', '') . ' MB';
    }

    return '0,00 MB'; // Return 0.00 MB if the request fails
}