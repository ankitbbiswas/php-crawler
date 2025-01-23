<?php

// Read the CSV data from CSV_INPUT/INPUT_CSV.csv into an array
function getCsvData() {

    // Path to the input CSV file
    $pathToFile = "CSV_INPUT/INPUT_CSV.csv";

    // Initialize an empty array to store the CSV data
    $getCsvDataArray = array();

    // Open the CSV file for reading in read mode ('r')
    if (file_exists($pathToFile)) {
        $handle = fopen($pathToFile, 'r');
    } else {
        die("File not found: " . $pathToFile);
    }

    // Check if the file was opened successfully (handle is not FALSE)
    if ($handle !== FALSE) {
        // Loop through each line in the CSV file using fgetcsv
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            // Convert to UTF-8 and store it in the array
            $getCsvDataArray[] = mb_convert_encoding($data[0], 'UTF-8', 'auto');
        }

        // Close the opened file handle
        fclose($handle);
    }

    return $getCsvDataArray;
}