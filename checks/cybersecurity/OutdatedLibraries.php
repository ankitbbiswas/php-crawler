<?php

// File: OutdatedLibraries.php
function checkOutdatedLibraries($sourceCode) {
    $outdatedLibraries = ['jquery-1.11.1.min.js', 'bootstrap-3.3.7.min.css'];
    foreach ($outdatedLibraries as $library) {
        if (strpos($sourceCode, $library) !== false) {
            return "Outdated library detected: $library.";
        }
    }
    return "-";
}