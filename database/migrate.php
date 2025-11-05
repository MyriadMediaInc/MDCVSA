<?php

// A simple script to run our database migrations

require_once __DIR__ . '/../src/bootstrap.php';

use App\Database;

// Get the PDO connection from our Database class
try {
    $pdo = Database::getInstance()->getConnection();
    echo "Database connection successful.\n";
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage() . "\n");
}

$migrations_path = __DIR__ . '/migrations';

// Get all .sql files from the migrations directory
$migration_files = glob($migrations_path . '/*.sql');

if (empty($migration_files)) {
    echo "No migration files found.\n";
    exit;
}

// Sort files to ensure they are run in order
sort($migration_files);

foreach ($migration_files as $file) {
    echo "Running migration: " . basename($file) . "...\n";
    try {
        $sql = file_get_contents($file);
        $pdo->exec($sql);
        echo "Success.\n";
    } catch (PDOException $e) {
        // You might want to add more sophisticated error handling here,
        // like tracking which migrations have already been run.
        die("Error running migration " . basename($file) . ": " . $e->getMessage() . "\n");
    }
}

echo "All migrations completed successfully.\n";
