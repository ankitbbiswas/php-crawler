<?php

// File: XssRisk.php
function checkXSS($sourceCode) {
    return preg_match('/<script\b[^>]*>([\s\S]*?)<\/script>/', $sourceCode) ? "Yes" : "-";
}