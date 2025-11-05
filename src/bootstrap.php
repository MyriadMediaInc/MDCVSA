<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use Dotenv\Dotenv;

// Load environment variables from .env file
if (class_exists(Dotenv::class)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} else {
    // Handle case where Dotenv is not available
    error_log('Dotenv class not found. Please run "composer install".');
}

try {
    // The autoloader knows where to find the Database class now.
    $db = Database::getInstance()->getConnection();
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Add any other application-wide bootstrap logic here
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', '1'); // Should be 0 in production
