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
    $dob = $_POST['dob'] ?? '';
    $address1 = $_POST['address_1'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip5 = $_POST['zip_5'] ?? '';
    $govt_id_image = $_FILES['govt_id_image'] ?? null;

    // The register_user function returns the new user's ID on success
    // or an array of errors on failure.
    $result = register_user(
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

    if (is_int($result)) {
        // On success, redirect to the new receipt page with the user's ID.
        header('Location: registration-success.php?user_id=' . $result);
        exit();
    } else {
        // If it's not an integer, it must be an array of errors.
        $errors = $result;
    }
}

// The view logic is in a separate file
include __DIR__ . '/views/pages/register.php';
