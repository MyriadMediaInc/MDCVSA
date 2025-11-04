<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env file
if (class_exists(Dotenv\Dotenv::class)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} else {
    // Handle case where Dotenv is not available
    // You might want to log an error or die with a message
    error_log('Dotenv class not found. Please run "composer install".');
}

// Include and instantiate the Database class
require_once __DIR__ . '/Database.php';

try {
    $db = Database::getInstance()->getConnection();
} catch (\PDOException $e) {
    // If the connection fails, we can't continue. 
    // In a real application, you'd want to show a user-friendly error page.
    die("Database connection failed: " . $e->getMessage());
}

// Add any other application-wide bootstrap logic here, like:
// - Setting the default timezone
// - Starting a session
// - Configuring error reporting

date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', '1'); // Should be 0 in production
