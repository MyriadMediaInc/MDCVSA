<?php

// register.php

// Include the bootstrap file to get things started
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Previous form fields
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $terms = $_POST['terms'] ?? '';

    // New Player Information fields
    $dob = $_POST['dob'] ?? '';
    $address1 = $_POST['address_1'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip5 = $_POST['zip_5'] ?? '';
    
    // Handle the file upload
    $govt_id_image = $_FILES['govt_id_image'] ?? null;

    // The register_user function will be updated to accept these new parameters.
    // It will return an array of errors. If the array is empty, registration was successful.
    $errors = register_user(
        $db,
        $firstName, 
        $lastName, 
        $email, 
        $password, 
        $passwordConfirm, 
        $terms,
        $dob,
        $address1,
        $city,
        $state,
        $zip5,
        $govt_id_image
    );

    if (empty($errors)) {
        // On success, redirect to the login page.
        header('Location: login.php?registered=true');
        exit();
    }
}

// The view logic will be in a separate file
include __DIR__ . '/views/pages/register.php';
