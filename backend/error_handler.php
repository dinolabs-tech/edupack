<?php
// Set a custom error handler function
set_error_handler("customErrorHandler");

// Set a custom exception handler function
set_exception_handler("customExceptionHandler");

// Function to log errors
function logError($errno, $errstr, $errfile, $errline) {
    $error_message = "[" . date("Y-m-d H:i:s") . "] E_ERROR: [$errno] $errstr in $errfile on line $errline\n";
    error_log($error_message, 3, "error_log.txt"); // Log to a file
}

// Function to handle exceptions
function customExceptionHandler($exception) {
    $error_message = "[" . date("Y-m-d H:i:s") . "] Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . "\n";
    error_log($error_message, 3, "error_log.txt"); // Log to a file
    // Display a user-friendly error message
    echo "<div class='error-message'>An unexpected error occurred. Please try again later.</div>";
}

// Function to handle errors
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Log the error
    logError($errno, $errstr, $errfile, $errline);

    // Display a user-friendly error message (you can customize this)
    echo "<div class='error-message'>An error occurred. Please try again later.</div>";

    // Prevent PHP's default error handler from running
    return true;
}
?>
