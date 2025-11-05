<?php

// register.php

// Include the bootstrap file to get things started
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $terms = $_POST['terms'] ?? '';

    // The register_user function returns an array of errors.
    // If the array is empty, registration was successful.
    $errors = register_user($db, $firstName, $lastName, $email, $password, $passwordConfirm, $terms);

    if (empty($errors)) {
        // On success, redirect to the login page.
        header('Location: login.php?registered=true');
        exit();
    }
}

// The view logic will be in a separate file
include __DIR__ . '/views/pages/register.php';
