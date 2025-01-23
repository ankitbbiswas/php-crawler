<?php

// File: Ssl.php
function checkSSL($url) {
    return strpos($url, 'https://') === 0 ? "Yes" : "-";
}