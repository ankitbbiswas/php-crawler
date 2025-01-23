<?php

// File: TwoFactorAuth.php
function checkTwoFactorAuth($sourceCode) {
    $twoFactorTools = ['two-factor', 'duo', 'authy', 'google-authenticator'];
    foreach ($twoFactorTools as $tool) {
        if (strpos($sourceCode, $tool) !== false) {
            return "Yes";
        }
    }
    return "-";
}