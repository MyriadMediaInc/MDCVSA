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
// This method is more reliable as it doesn't depend on DOCUMENT_ROOT.
// It deduces the base path from the script's URL, which is always correct.
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

// Get the URL path of the currently executing script.
$script_name = $_SERVER['SCRIPT_NAME']; // e.g., /mdcvsa/public/admin/leagues.php

// Find the position of '/public/', which is our web root marker.
$public_pos = strpos($script_name, '/public/');

if ($public_pos !== false) {
    // The base path is the portion of the URL before '/public/'.
    $base_path = substr($script_name, 0, $public_pos);
} else {
    // Fallback for any script that might be running outside the /public directory.
    // This is a safety measure and shouldn't normally be hit.
    $base_path = rtrim(dirname($script_name), '/');
}

// Clean up trailing slashes for consistency.
$base_path = rtrim($base_path, '/');

define('BASE_URL', $protocol . $host . $base_path);
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
