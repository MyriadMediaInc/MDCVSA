<?php

// registration-success.php

// Basic bootstrap
require_once __DIR__ . '/src/bootstrap.php';
require_once __DIR__ . '/src/auth.php';

// Get the user ID from the URL query parameter
$user_id = $_GET['user_id'] ?? null;

// If there's no user ID, we can't show anything.
if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Fetch user and player data. All data is in the 'people' table.
$user = get_user_by_id($db, (int)$user_id);

// If the user can't be found, something is wrong.
if (!$user) {
    // Redirect to login or show an error. For now, we'll just go to login.
    header('Location: login.php');
    exit;
}

$pageTitle = 'Registration Successful';
// The view will need the $user variable, so we pass it implicitly.
$contentView = __DIR__ . '/views/pages/registration-success.php';

// Render the layout
include __DIR__ . '/views/layouts/app.php';

?>
