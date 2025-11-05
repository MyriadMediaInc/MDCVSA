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

// --- FIX: Define BASE_URL --- //
// This dynamically creates the base URL, so it works on any server.
// It creates a URL like 'http://13.222.190.11/mdcvsa'
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
// Assumes the entry point (e.g., index.php) is in a subdirectory of the web root.
// dirname($_SERVER['SCRIPT_NAME']) gets the directory part of the URL.
$script_dir = dirname($_SERVER['SCRIPT_NAME']);
// If the script is in the root, dirname might return '/' or '\'. In that case, we want an empty string.
$base_path = ($script_dir === '/' || $script_dir === '\\') ? '' : $script_dir;
define('BASE_URL', $protocol . $host . $base_path);
// --- END FIX ---

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
