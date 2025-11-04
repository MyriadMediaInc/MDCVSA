<?php
session_start();
require_once 'config/bootstrap.php';

// If the user is already logged in, redirect them to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$error = null;
$page = 'login';
$title = 'Login';
$body_class = 'login-page'; // Special class for AdminLTE login layout

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        // Find the user by email
        // NOTE: We will need to implement the findByEmail method in the Person model
        $person = $entityManager->getRepository('Person')->findOneBy(['email' => $email]);

        if ($person && password_verify($password, $person->getPasswordHash())) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $person->getPersonId();
            $_SESSION['user_name'] = $person->getFirstName();

            // Redirect to the main dashboard page
            header("Location: /index.php");
            exit;
        } else {
            // Invalid credentials
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Email and password are required.";
    }
}

// The layout.php file will render the header, footer, and the login page content
require_once 'views/layout.php';
