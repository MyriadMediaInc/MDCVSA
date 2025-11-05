<?php

// register.php

// Include the bootstrap file to get things started
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];
$success_message = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    // The register_user function returns an array of errors.
    // If the array is empty, registration was successful.
    $errors = register_user($db, $fullName, $email, $password, $passwordConfirm);

    if (empty($errors)) {
        $success_message = "Registration successful! You can now log in.";
        // Optionally, you could redirect the user to the login page here
        // header('Location: /mdcvsa/login.php');
        // exit();
    }
}

// The view logic will be in a separate file
include __DIR__ . '/views/pages/register.php';
