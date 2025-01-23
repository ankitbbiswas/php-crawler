<?php

// File: DirectoryTraversal.php
function checkDirectoryTraversal($url) {
    $traversalStrings = ['../', '..\\', '%2e%2e%2f', '%2e%2e%5c'];
    foreach ($traversalStrings as $traversal) {
        if (strpos($url, $traversal) !== false) {
            return "Yes";
        }
    }
    return "-";
}