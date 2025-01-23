<?php

function FILEOPS_checkFileExists($directory, $filename) {
    // Check if the file exists
    $filePath = $directory . "/" . $filename;
    if (!file_exists($filePath)) {
        // If not, create it
        $file = fopen($filePath, 'w') or die("Unable to create file!");
        fclose($file);
    }
}

?>