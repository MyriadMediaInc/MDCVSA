<?php

require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];

// Check if the user has just been redirected from registration
if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
    // Although we aren't displaying a message, this prevents errors if the parameter is present.
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Call the login function, which will handle session creation
    $errors = login_user($db, $email, $password);

    // If there are no errors, login was successful
    if (empty($errors)) {
        // Redirect to the main dashboard page
        header("Location: index.php");
        exit(); // Ensure no further code is executed after redirect
    }
}

// Include the view file. If there were errors, the $errors array will be available to it.
include __DIR__ . '/views/pages/login.php';
