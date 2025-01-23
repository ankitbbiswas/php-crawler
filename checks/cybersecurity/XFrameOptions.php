<?php

// File: XFrameOptions.php
function checkXFrameOptions($sourceCode) {
    return strpos($sourceCode, 'X-Frame-Options') !== false ? "Yes" : "-";
}