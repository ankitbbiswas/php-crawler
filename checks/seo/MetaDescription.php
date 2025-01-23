<?php

// File: MetaDescription.php
function checkMetaDescription($sourceCode) {
    if (preg_match('/<meta name="description" content="(.*?)"\/>/', $sourceCode)) {
        return "Yes";
    } else {
        return "-";
    }
}