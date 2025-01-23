<?php

// File: OpenPorts.php
function checkOpenPorts($url) {
    $domain = parse_url($url, PHP_URL_HOST);
    $ports = [21, 22, 23, 25, 80, 110, 143, 443, 445, 3306, 3389];
    $openPorts = [];
    foreach ($ports as $port) {
        $connection = @fsockopen($domain, $port, $errno, $errstr, 1);
        if ($connection) {
            $openPorts[] = $port;
            fclose($connection);
        }
    }
    return $openPorts ? "Open ports: " . implode(', ', $openPorts) : "-";
}