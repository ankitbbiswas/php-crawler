<?php

// Check Imprint for German variations
function CheckImprint($sourceCode) {
    if (empty($sourceCode)) {
        return '-'; // Return "-" if no source code
    }

    // Convert source code to lowercase for case-insensitive search
    $sourceCodeLower = strtolower($sourceCode);

    // German variations of "Impressum"
    $imprintKeywords = [
        'impressum',       // Core keyword
        'impr.',           // Abbreviation
        'impressum:',      // Variations with special characters
        'impressum -',
        'impressum –',
        'impressum |',
        'impressum/',
        '[impressum]',     // Variations with brackets
        '(impressum)',
        'impressum.htm',   // File extensions
        'impressum.html',
        'impressum.php',
        'impressum.php?',
    ];

    // Check for "Impressum" inside links or text content
    foreach ($imprintKeywords as $keyword) {
        // Look for keywords inside href attributes of <a> tags
        $hrefPattern = '/<a[^>]*href=["\'][^"\']*' . preg_quote($keyword, '/') . '[^"\']*["\'][^>]*>/i';
        if (preg_match($hrefPattern, $sourceCodeLower)) {
            return 'Yes'; // Found keyword in a link
        }

        // Look for keywords in the visible text of <a> tags
        $textPattern = '/<a[^>]*>(.*?)' . preg_quote($keyword, '/') . '(.*?)<\/a>/i';
        if (preg_match($textPattern, $sourceCodeLower)) {
            return 'Yes'; // Found keyword in the text of a link
        }
    }

    // Check for "Impressum" specifically near the end (e.g., in footer)
    $footerText = substr($sourceCodeLower, -1000); // Check the last 1000 characters
    if (strpos($footerText, 'impressum') !== false) {
        return 'Yes'; // Imprint found in the footer
    }

    return 'No'; // Imprint not found
}