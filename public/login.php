<?php
// public/login.php (Standalone Page)

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/auth.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Establish the database connection for the login attempt.
    $db = (new Database())->getConnection();

    $errors = login_user($db, $email, $password);

    if (empty($errors)) {
        // On successful login, redirect to the main dashboard which uses the app layout.
        header("Location: index.php");
        exit();
    }
}

// This page is standalone and does not use the main app layout.
// It includes the view directly.
include __DIR__ . '/../views/pages/login.php';
