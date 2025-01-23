<?php

// File: SRI.php
function checkSRI($sourceCode) {
    return preg_match('/<script\s[^>]*integrity=["\']sha(256|384|512)-[^"\']+["\'][^>]*><\/script>/', $sourceCode) ? "Yes" : "-";
}