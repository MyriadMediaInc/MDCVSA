<?php

// Start the session
session_start();

// If the user is not logged in, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Basic bootstrap
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

// Page-specific variables
$pageTitle = 'Dashboard';
$contentView = __DIR__ . '/../views/pages/dashboard.php';

// Render the layout
include __DIR__ . '/../views/layouts/app.php';
