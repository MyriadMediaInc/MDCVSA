<?php

// registration-success.php

// Basic bootstrap
require_once __DIR__ . '/src/bootstrap.php';

// Get the user ID from the URL query parameter
$user_id = $_GET['user_id'] ?? null;

// If there's no user ID, we can't show anything.
if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Fetch user and player data
$user = find_user_by_id($db, (int)$user_id);
$player = find_player_by_user_id($db, (int)$user_id);

// If the user or player can't be found, something is wrong.
if (!$user) {
    // Redirect to login or show an error. For now, we'll just go to login.
    header('Location: login.php');
    exit;
}

$pageTitle = 'Registration Successful';
$contentView = __DIR__ . '/views/pages/registration-success.php';

// Render the layout
include __DIR__ . '/views/layouts/app.php';

?>
