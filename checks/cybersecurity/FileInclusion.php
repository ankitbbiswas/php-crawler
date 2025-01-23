<?php

// File: FileInclusion.php
function checkFileInclusion($sourceCode) {
    return preg_match('/include\s*[("]*\s*\$_(GET|POST|REQUEST|SERVER|ENV)/i', $sourceCode) ? "Yes" : "-";
}