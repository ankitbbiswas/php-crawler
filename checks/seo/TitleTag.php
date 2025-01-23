<?php

// File: TitleTag.php
function checkTitleTag($sourceCode) {
    if (preg_match('/<title>(.*?)<\/title>/', $sourceCode)) {
        return "Yes";
    } else {
        return "-";
    }
}