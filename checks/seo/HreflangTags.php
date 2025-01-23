<?php

// File: HreflangTags.php
function checkHreflangTags($sourceCode) {
    if (preg_match('/<link rel="alternate" hreflang="(.*?)" href="(.*?)"\/>/', $sourceCode)) {
        return "Yes";
    } else {
        return "-";
    }
}