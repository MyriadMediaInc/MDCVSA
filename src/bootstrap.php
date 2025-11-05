<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use Dotenv\Dotenv;

// --- BEGIN DEBUGGING ---
echo "Starting bootstrap.php<br>";

$dotenv_path = __DIR__ . '/../';
echo "Dotenv path: " . realpath($dotenv_path) . "<br>";
echo ".env file exists? " . (file_exists($dotenv_path . '.env') ? 'Yes' : 'No') . "<br>";
echo ".env file is readable? " . (is_readable($dotenv_path . '.env') ? 'Yes' : 'No') . "<br>";
// --- END DEBUGGING ---

// Load environment variables from .env file
if (class_exists(Dotenv::class)) {
    $dotenv = Dotenv::createImmutable($dotenv_path);
    try {
        $dotenv->load();
        // --- BEGIN DEBUGGING ---
        echo "Dotenv->load() was called.<br>";
        // --- END DEBUGGING ---
    } catch (\Exception $e) {
        // --- BEGIN DEBUGGING ---
        echo "Dotenv threw an exception: " . $e->getMessage() . "<br>";
        // --- END DEBUGGING ---
    }
} else {
    // --- BEGIN DEBUGGING ---
    echo "Dotenv class does not exist.<br>";
    // --- END DEBUGGING ---
}

// --- BEGIN DEBUGGING ---
$db_host_after_load = getenv('DB_HOST');
echo "DB_HOST value after load: '";
var_dump($db_host_after_load);
echo "'<br>";

// Let's also check the \$_ENV superglobal
$db_host_from_env = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'Not set in $_ENV';
echo "DB_HOST from \$_ENV: '" . $db_host_from_env . "'<br>";

die("--- End of debug script ---");
// --- END DEBUGGING ---


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
