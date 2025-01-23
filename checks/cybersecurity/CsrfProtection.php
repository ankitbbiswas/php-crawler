<?php

 // File: CsrfProtection.php
function checkCSRFProtection($sourceCode) {
    return preg_match('/<input[^>]+name=["\']csrf_token["\'][^>]+>/', $sourceCode) ? "Yes" : "-";
}