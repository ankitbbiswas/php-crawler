<?php

// File: XMLRPC.php
function checkXMLRPC($sourceCode) {
    return strpos($sourceCode, 'xmlrpc.php') !== false ? "Yes" : "-";
}