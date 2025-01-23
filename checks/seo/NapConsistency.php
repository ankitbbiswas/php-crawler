<?php

// File: NapConsistency.php
function checkNapConsistency($sourceCode, $name, $address, $phone) {
    $hasName = strpos($sourceCode, $name) !== false;
    $hasAddress = strpos($sourceCode, $address) !== false;
    $hasPhone = strpos($sourceCode, $phone) !== false;

    if ($hasName && $hasAddress && $hasPhone) {
        return "Yes";
    } else {
        return "-";
    }
}