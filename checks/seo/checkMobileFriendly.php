<?php

// File: MobileFriendly.php
function checkMobileFriendly($sourceCode) {
    return strpos($sourceCode, 'meta name="viewport"') !== false ? "Yes" : "-";
}