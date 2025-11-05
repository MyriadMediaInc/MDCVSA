<?php

// login.php

require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $errors = login_user($db, $email, $password);

    if (empty($errors)) {
        // On successful login, we set a success message.
        // The JavaScript will then redirect the user to the dashboard.
        $success_message = "Login successful! Redirecting...";
    }
}

// The view logic will be in a separate file
include __DIR__ . '/views/pages/login.php';
