<?php

// File: ReferrerPolicy.php
function checkReferrerPolicy($sourceCode) {
    return strpos($sourceCode, 'Referrer-Policy') !== false ? "Yes" : "-";
}