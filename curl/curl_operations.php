<?php

// File: curl_operations.php

function CheckHTTPStatus($url) {
    $maxTimeout = 10;
    $printStatusCode = true;
    $defaultStatusCode = 0;
    $curlVerbose = false;

    set_time_limit($maxTimeout);
    ob_start();

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, $curlVerbose);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, $maxTimeout);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ((int) $httpCode !== 200) {
        $httpCode = $defaultStatusCode !== 0 ? $defaultStatusCode : $httpCode;
    }

    http_response_code($httpCode);
    curl_close($ch);
    ob_end_clean();

    return $printStatusCode ? $httpCode : false;
}

/**
 * Fetches the source code of a given URL using cURL.
 *
 * @param string $url The URL from which to fetch the source code.
 * @return string|false The source code of the page or false on failure.
 */
function fetchSourceCode($url) {
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set timeout in seconds

    // Execute cURL request and store the result
    $result = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        // Log or handle the error if needed
        error_log("cURL error: " . curl_error($ch));
        curl_close($ch);
        return false; // Return false if there's an error
    }

    // Close the cURL session
    curl_close($ch);

    // Return the fetched content
    return $result;
}