<?php

// File: XContentTypeOptions.php
function checkXContentTypeOptions($sourceCode) {
    return strpos($sourceCode, 'X-Content-Type-Options') !== false ? "Yes" : "-";
}