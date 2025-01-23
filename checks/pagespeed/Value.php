<?php

// Function to make a request to the Google PageSpeed API
function getPageSpeedData($url, $apiKey, $strategy) {
    $endpoint = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed";
    $params = [
        'url' => $url,
        'key' => $apiKey,
        'strategy' => $strategy  // 'mobile' or 'desktop'
    ];

    // Build the full URL with parameters
    $apiUrl = $endpoint . '?' . http_build_query($params);

    // Use cURL to make the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
        return null;
    }

    curl_close($ch);

    // Decode the response to associative array
    return json_decode($response, true);
}

// Function to safely retrieve nested values from the PageSpeed API response
function getValue($array, $keys) {
    foreach ($keys as $key) {
        if (!isset($array[$key])) {
            return null;  // Return null if any key is missing
        }
        $array = $array[$key];
    }
    return $array;
}

// Function to retrieve PageSpeed score for both mobile and desktop
function getPageSpeedScores($url, $apiKey) {
    // Get the mobile score
    $mobileData = getPageSpeedData($url, $apiKey, 'mobile');
    $mobileScore = getValue($mobileData, ['lighthouseResult', 'categories', 'performance', 'score']);
    return ($mobileScore !== null ? $mobileScore * 100 : "No score") . "\n";

    // Get the desktop score
    $desktopData = getPageSpeedData($url, $apiKey, 'desktop');
    $desktopScore = getValue($desktopData, ['lighthouseResult', 'categories', 'performance', 'score']);
    return ($desktopScore !== null ? $desktopScore * 100 : "No score") . "\n";

    // Multiply by 100 to get the score as a percentage
    $mobileScoreFormatted = ($mobileScore !== null) ? $mobileScore * 100 : "No score";
    $desktopScoreFormatted = ($desktopScore !== null) ? $desktopScore * 100 : "No score";

    // Echo the results
    return "For mobile: " . $mobileScoreFormatted . "\n";
    return "For desktop: " . $desktopScoreFormatted . "\n";
}