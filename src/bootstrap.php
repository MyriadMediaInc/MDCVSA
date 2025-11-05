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
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

// Get the full URL to the currently executing script, without the query string.
$current_script_url = strtok($_SERVER['REQUEST_URI'], '?');

// Get the full filesystem path to the project's root directory (one level above this file's 'src' directory)
$project_root_fs = dirname(__DIR__);

// Get the full filesystem path to the currently executing script.
$script_filename_fs = $_SERVER['SCRIPT_FILENAME'];

// Get the script's path relative to the project root.
// e.g., /public/admin/leagues.php
$script_path_relative = str_replace($project_root_fs, '', $script_filename_fs);

// Replace backslashes on Windows
$script_path_relative = str_replace('\\', '/', $script_path_relative);

// Deduce the base path by removing the relative script path from the full URL.
// e.g., /mdcvsa/public/admin/leagues.php  - /public/admin/leagues.php  = /mdcvsa
$base_path = str_replace($script_path_relative, '', $current_script_url);

// Clean up any trailing slashes for consistency.
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
