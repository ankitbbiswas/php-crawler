<?php

function saveAsHtmlFile($resultPath, $sourceCode, $url){
    // Remove special characters from URL if existing
    $fileName = sanitizeFileName($url);
    
    // Datum und Zeit in einen Teil des Dateinamens umwandeln
    $dateAndTimeString = getDateTimeString(time());
    
    // Full path to file
    $fullFileName = $fileName . "_" . $dateAndTimeString;
    
    // Create file at specified path
    $fp = @fopen($resultPath . "/" . $fullFileName . ".html", "w");
    
    // Write into file as original HTML code by curl
    fputs($fp, $sourceCode);
    
    // Close file
    fclose($fp);
}