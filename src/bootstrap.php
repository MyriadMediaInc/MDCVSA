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
// This is the path from the web server's document root to the project's public folder.
// In the URL http://13.222.190.11/mdcvsa/public/index.php, the base project path is /mdcvsa
$base_project_path = '/mdcvsa'; // Hardcoded for reliability

define('BASE_URL', $protocol . $host . $base_project_path);
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
