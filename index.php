<?php

// This is the router file for the PHP built-in web server.

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Serve assets from the vendor directory
if (preg_match('/^\/vendor\/(.*)/', $requestedPath, $matches)) {
    $vendor_file = __DIR__ . '/vendor/' . $matches[1];
    if (is_file($vendor_file)) {
        // Determine the correct MIME type
        $mime_type = mime_content_type($vendor_file);
        header('Content-Type: ' . $mime_type);
        readfile($vendor_file);
        return true;
    }
}

// Serve static files from the public directory if they exist
if (is_file(__DIR__ . '/public' . $requestedPath)) {
    return false; // Serve the requested resource as-is.
}

// For any other request, route to our main application entry point
require_once __DIR__ . '/public/index.php';

