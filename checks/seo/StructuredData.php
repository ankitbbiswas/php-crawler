<?php

// File: StructuredData.php
function checkStructuredData($sourceCode) {
    if (preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/', $sourceCode)) {
        return "Yes";
    } else {
        return "-";
    }
}