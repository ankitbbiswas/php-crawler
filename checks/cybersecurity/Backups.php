<?php

// File: Backups.php
function checkBackups($sourceCode) {
    $backupTools = ['updraftplus', 'backupbuddy', 'backwpup', 'vaultpress'];
    foreach ($backupTools as $tool) {
        if (strpos($sourceCode, $tool) !== false) {
            return "Yes";
        }
    }
    return "-";
}