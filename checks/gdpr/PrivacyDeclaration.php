<?php

// Check for Data Privacy
function CheckDataPrivacy($sourceCode) {
    if ($sourceCode === '') {
        return false;
    }

    // Convert source code to lowercase for case-insensitive search
    $sourceCodeLower = strtolower($sourceCode);
    
    // Variations of "Datenschutz" and "Data Privacy"
    $dataPrivacyKeywords = [
        // German keywords
        'datenschutz',
        'datenschutzrichtlinie',
        'datenschutzerklärung',
        'datenschutz-bestimmungen',
        'datenschutzvereinbarung',
        'datenschutzgesetz',
        'privatsphäre',

        // English keywords
        'data privacy',
        'privacy policy',
        'privacy agreement',
        'privacy statement',
        'data protection'
    ];

    // Search for keywords in the source code
    foreach ($dataPrivacyKeywords as $keyword) {
        if (strpos($sourceCodeLower, $keyword) !== false) {
            return "Yes"; // Data privacy statement found
        }
    }
    
    return "-"; // Data privacy statement not found
}
