<?php
// File: Https.php
function checkHttps($url) {
    return strpos($url, 'https://') === 0 ? "Yes" : "-";
}