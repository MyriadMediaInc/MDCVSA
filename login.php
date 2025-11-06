<?php
// login.php (Root Controller)

// This file has been refactored to work correctly with the main app layout.

// 1. Load the core bootstrap and authentication functions.
// The autoloader and database connection will be handled by the main layout.
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

$errors = [];

// 2. Check for form submission.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Create the database connection.
    // This was the missing piece causing the 500 error.
    $db = (new Database())->getConnection();

    // Call the login function, which will handle session creation.
    $errors = login_user($db, $email, $password);

    // If there are no errors, login was successful.
    if (empty($errors)) {
        // Redirect to the main dashboard page.
        header("Location: index.php");
        exit(); // Ensure no further code is executed after redirect.
    }
}

// 3. Set page-specific variables to be used in the layout.
$pageTitle = 'Login';
// Point to the simple view file, not one that includes the layout again.
$contentView = __DIR__ . '/views/pages/login.php';

// 4. Include the main application layout.
// The layout will handle the HTML head, header, sidebar, and footer.
// It will also make the $errors variable available to the $contentView.
include __DIR__ . '/views/layouts/app.php';
