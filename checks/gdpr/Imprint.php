<?php

// Function to fetch URL contents using cURL
function fetchUrlContent($url) {
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
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        return $response; // Return response if successful
    }

    return false; // Return false on error
}

// Function to check for Imprint or Impressum
function CheckImprint($sourceCode) {
    if (empty($sourceCode)) {
        return 'No'; // Return "No" if no source code
    }

    // Convert source code to lowercase for case-insensitive search
    $sourceCodeLower = strtolower($sourceCode);

    // Keywords for Impressum and Imprint (German and English variations)
    $imprintKeywords = [
        'impressum', 'impr.', 'impressum:', 'impressum -', 'impressum –', 
        'impressum |', 'impressum/', '[impressum]', '(impressum)',
        'impressum.htm', 'impressum.html', 'impressum.php', 'impressum.php?',
        'imprint', 'imprint:', 'imprint -', 'imprint –', 
        'imprint |', 'imprint/', '[imprint]', '(imprint)',
        'imprint.htm', 'imprint.html', 'imprint.php', 'imprint.php?',
    ];

    // Check for keywords in the source code
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

    // Check for "Impressum" or "Imprint" in the <header> section
    if (preg_match('/<header.*?>.*?(impressum|imprint).*?<\/header>/is', $sourceCodeLower)) {
        return 'Yes'; // Found keyword in the header section
    }

    // Check for "Impressum" or "Imprint" in the <footer> section
    if (preg_match('/<footer.*?>.*?(impressum|imprint).*?<\/footer>/is', $sourceCodeLower)) {
        return 'Yes'; // Found keyword in the footer section
    }

    // If the <footer> tag is not explicitly available, check the last 1000 characters of the page
    $footerText = substr($sourceCodeLower, -1000); // Check the last 1000 characters
    if (strpos($footerText, 'impressum') !== false) {
        return 'Yes'; // Imprint found in the footer content
    }
    if (strpos($footerText, 'imprint') !== false) {
        return 'Yes'; // Imprint found in the footer content
    }

    return 'No'; // Imprint not found
}

foreach ($urls as $url) {
    // Fetch the source code from the URL
    $fetchResult = fetchUrlContent($url);

    if ($fetchResult === false) {
        // Output error if fetching failed
        echo "URL: $url - Status: Unable to fetch content\n";
        continue;
    }

    // Check the fetched source code for Imprint or Impressum
    $checkResult = CheckImprint($fetchResult);
}
