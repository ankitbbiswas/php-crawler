<?php

// Function to check if the sitemap exists at the given URL
function checkSitemap($url) {
    // Ensure the URL is a valid string
    if (!isset($url) || !is_string($url)) {
        return "Invalid";  // Return a message indicating invalid URL
    }

    // Parse the URL to extract the host
    $parsedUrl = parse_url($url);
    if ($parsedUrl === false || !isset($parsedUrl['host'])) {
        return "-";  // Return a message for invalid URL structure
    }

    // Construct the sitemap URL by appending "/sitemap.xml" to the base URL
    $sitemapUrl = rtrim($url, '/') . '/sitemap.xml';

    // Attempt to retrieve the sitemap content
    $response = @file_get_contents($sitemapUrl);

    // Check if the response was successful
    if ($response === false) {
        return "Yes";  // Return a message indicating sitemap is not present
    } else {
        return "-";  // Return a message indicating sitemap is found
    }
}