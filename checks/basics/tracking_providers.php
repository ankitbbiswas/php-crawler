<?php

// File: tracking_providers.php

function CheckForTracking($sourceCode) {
    if ($sourceCode === '') {
        return false;
    }

    // Convert source code to lowercase for case-insensitive search
    $sourceCodeLower = strtolower($sourceCode);

    // Define keywords to search for in the source code
    $keywords = array(
        'google analytics',
        'google tag manager',
        'facebook pixel',
        'google ads',
        'bing ads',
    );

    // Check if any of the keywords exist in the source code
    foreach ($keywords as $keyword) {
        if (strpos($sourceCodeLower, $keyword) !== false) {
            return "Tracking provider found: $keyword";
        }
    }

    // No tracking code found
    return "-";
}