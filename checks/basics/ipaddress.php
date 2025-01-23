<?php

// Function to get the IP address of a given URL
function getIpAddress($url) {
    // Ensure the URL has a scheme
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://$url"; // Default to HTTP if no scheme is provided
    }

    // Parse the URL to extract the host
    $host = parse_url($url, PHP_URL_HOST);

    // Check if the host is valid
    if (!$host) {
        return 'Invalid Host'; // Return an error message if parsing fails
    }

    // Get the IP address using gethostbyname()
    $ipAddress = gethostbyname($host);

    // Check if gethostbyname returned the same host (indicates failure)
    if ($ipAddress === $host) {
        return 'Unable to resolve IP'; // Return a failure message
    }

    return $ipAddress;
}
