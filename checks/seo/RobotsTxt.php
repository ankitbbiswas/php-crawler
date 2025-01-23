<?php

// Function to check if the robots.txt file exists and contains "User-agent"
function checkRobotsTxt($url) {
    // Construct the robots.txt URL by appending "/robots.txt" to the base URL
    $robotsUrl = rtrim($url, '/') . '/robots.txt';
    
    // Fetch the content of the robots.txt file
    $sourceCode = @file_get_contents($robotsUrl);

    // Check if the content was successfully retrieved
    if ($sourceCode === false) {
        return "Failed to retrieve robots.txt for $url\n";
        return false; // Indicate failure to fetch robots.txt
    }

    // Ensure the sourceCode is a string before using strpos
    if (is_string($sourceCode)) {
        // Check for the presence of 'User-agent' in the robots.txt file
        if (strpos($sourceCode, 'User-agent') !== false) {
            return "Yes";
            return true; // Indicate success (User-agent found)
        } else {
            return "-";
            return false; // Indicate no User-agent found
        }
    } else {
        // Handle the case when $sourceCode is null or not a string
        return "Invalid source code retrieved for $url\n";
        return false;
    }
}