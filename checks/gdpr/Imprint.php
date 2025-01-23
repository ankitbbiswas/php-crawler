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
        'impressum',
        'impressums',   
        'impr.',     
        'impressum:',   
        'impressum -',  
        'impressum –',       
        'impressum |',  
        'impressum/',   
        '[impressum]',  
        '(impressum)',  
        'impressum.htm',     
        'impressum.html',    
        'impressum.php',    
        'impressum.php?'     
    ];

    // Search for keywords in the source code
    foreach ($imprintKeywords as $keyword) {
        if (strpos($sourceCodeLower, $keyword) !== false) {
            return 'Yes'; // Imprint found
        }
    }

    // Check for imprint specifically at the end (e.g., in footer)
    if (preg_match('/impressum/i', substr($sourceCode, -500))) {
        return 'Yes'; // Imprint found in the footer
    }

    return '-'; // Imprint not found
}
