<?php
// This is the index.php file for the library folder

// Prevent direct access to the folder
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    // Redirect or show an error message
    header("HTTP/1.0 403 Forbidden");
    echo "Access to this directory is restricted.";
    exit;
}

// Autoload classes or functions from the library folder
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/' . $class_name . '.php';
    if (file_exists($file)) {
        include $file;
    }
});

// Example: Initialize a library file if needed
// include 'file_operations.php';
// include 'helper_functions.php';

// Example function to demonstrate how this index could be used
function initializeLibraries() {
    // Load all necessary library functions or classes here
    echo "Libraries have been initialized.";
}

// Call the function to initialize
initializeLibraries();
?>