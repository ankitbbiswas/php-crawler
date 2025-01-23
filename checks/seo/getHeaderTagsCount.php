<?php

// File: getHeaderTagsCount.php
function getHeaderTagsCount($sourceCode) {
    $headerCount = preg_match_all('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', $sourceCode, $matches);
    return "Number of header tags: " . $headerCount;
}