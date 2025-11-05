<?php

// login.php

require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];
$success_message = '';
$registration_success = false; // Flag for new registration

// Check if the user has just been redirected from registration
if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
    $registration_success = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $errors = login_user($db, $email, $password);

    if (empty($errors)) {
        // On successful login, set the success message for redirection.
        $success_message = "Login successful! Redirecting...";
    }
}

// The view logic will be in a separate file
include __DIR__ . '/views/pages/login.php';
