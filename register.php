<?php

// register.php

// Include the bootstrap file to get things started
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // The register_user function now expects all these parameters.
    // We will update it in the next step.
    $result = register_user(
        $db,
        $_POST['first_name'] ?? '',
        $_POST['last_name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['password'] ?? '',
        $_POST['password_confirm'] ?? '',
        $_POST['terms'] ?? '',
        $_POST['dob'] ?? '',
        $_POST['address_1'] ?? '',
        $_POST['address_2'] ?? null, // Now included
        $_POST['city'] ?? '',
        $_POST['state'] ?? '',
        $_POST['zip_5'] ?? '',
        $_POST['zip_4'] ?? null, // Now included
        $_POST['phone'] ?? null, // Now included
        $_FILES['govt_id_image'] ?? null
    );

    if (is_int($result)) {
        // On success, redirect to the success page with the new user's ID.
        header('Location: registration-success.php?user_id=' . $result);
        exit();
    } else {
        // If it's not an integer, it must be an array of errors.
        $errors = $result;
    }
}

// The view logic, which contains the HTML form, is in a separate file.
// We will update this view next to add the missing input fields.
include __DIR__ . '/views/pages/register.php';
