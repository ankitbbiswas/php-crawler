<?php

// Function to check the HTTP status for different URL variations
function CheckHTTP($url) {
    // Add default scheme if missing (assuming http)
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;  // Assume http if no scheme provided
    }

    // Parse the host from the original URL
    $host = parse_url($url, PHP_URL_HOST);
    if (!$host) {
        return ['Original URL' => 'Invalid URL']; // If URL parsing fails, return error
    }

    // Variations of the URL to check
    $urlVariations = [
        'Original URL' => $url,
        'https:// Status' => 'https://' . $host,
        'http:// Status' => 'http://' . $host,
        'https://www. Status' => 'https://www.' . $host,
        'http://www. Status' => 'http://www.' . $host,
    ];

    // Array to store results
    $statusResults = [];

    // Loop through each variation and get the HTTP status
    foreach ($urlVariations as $key => $variantUrl) {
        $httpCode = getHttpStatusCode($variantUrl);
        $statusResults[$key] = $httpCode;
    }

    return $statusResults;
}

// Helper function to get the HTTP status code of a URL
function getHttpStatusCode($url) {
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true); // Don't fetch the body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout after 10 seconds

    // Execute the cURL request
    curl_exec($ch);

    // Get the HTTP status code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL handle
    curl_close($ch);

    // Return the HTTP status code or 'Error' if unavailable
    return $httpCode ?: "Error"; // If cURL fails, return "Error"
}
