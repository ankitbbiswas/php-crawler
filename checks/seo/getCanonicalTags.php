<?php

// checks/seo/getCanonicalTags.php

function getCanonicalTags($sourceCode) {
    // Use a regular expression to find the canonical link tag in the HTML
    if (preg_match('/<link rel=["\']canonical["\'] href=["\']([^"\']+)["\']\s*\/?>/i', $sourceCode, $matches)) {
        return $matches[1];  // Return the href attribute of the canonical tag
    }

    // Return null if no canonical tag is found
    return "-";
}