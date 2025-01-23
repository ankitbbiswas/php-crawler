<?php

// File: CSP.php
function checkCSP($sourceCode) {
    return strpos($sourceCode, 'Content-Security-Policy') !== false ? "Yes" : "-";
}