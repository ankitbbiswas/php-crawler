<?php

// Function to check if the URL uses HTTPS and handle exceptions
function checkSecurityCertificates($url) {

    // Create a stream context for SSL certificate checking
    $context = stream_context_create([
        'ssl' => [
            'capture_peer_cert' => true,
        ],
    ]);

    // Attempt to open a connection to the URL
    $client = @stream_socket_client("ssl://$url:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);

    // Retrieve the SSL certificate
    $params = stream_context_get_params($context);
    $cert = $params['options']['ssl']['peer_certificate'] ?? null;

    if ($cert) {
        return "Yes";
    } else {
        return "-";
    }

    // Close the connection
    fclose($client);
}