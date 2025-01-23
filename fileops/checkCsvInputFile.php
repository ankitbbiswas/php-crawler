<?php

function checkCsvInputFile($directory, $filename) {
    $filePath = $directory . "/" . $filename;
    if (!is_dir($directory) || !is_readable($directory)) {
        echo "Directory not found or not readable: $directory\n";
        return false;
    }

    if (!file_exists($filePath)) {
        echo "File not found: $filePath\n";
        return false;
    }

    return true;
}
