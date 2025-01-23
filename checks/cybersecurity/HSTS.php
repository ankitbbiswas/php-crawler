<?php

// File: HSTS.php
function checkHSTS($sourceCode) {
    return strpos($sourceCode, 'Strict-Transport-Security') !== false ? "Yes" : "-";
}