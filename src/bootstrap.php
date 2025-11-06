<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use Dotenv\Dotenv;

// Load environment variables from .env file
if (class_exists(Dotenv::class)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} else {
    error_log('Dotenv class not found. Please run "composer install".');
}

// --- FIX: Define a robust BASE_URL --- //
// The web server's DocumentRoot is pointed to the /public directory.
// The project itself is accessed via the /mdcvsa path.
// Therefore, the BASE_URL must be exactly this.
define('BASE_URL', 'http://13.222.190.11/mdcvsa');
// --- END FIX ---

try {
    $db = Database::getInstance()->getConnection();
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Add any other application-wide bootstrap logic here
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', '1'); // Should be 0 in production
