<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/league.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $league_name = trim(filter_input(INPUT_POST, 'league_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $date_formed = trim(filter_input(INPUT_POST, 'date_formed'));
    $date_disbanded = trim(filter_input(INPUT_POST, 'date_disbanded'));

    // --- FIX: Server-side validation for required fields ---
    if (empty($league_name)) {
        $errors[] = 'League name is required.';
    }
    if (empty($date_formed)) {
        $errors[] = 'Date formed is required.';
    }
    if (empty($date_disbanded)) {
        $errors[] = 'Date disbanded is required.';
    }
    // --- END FIX ---

    if (empty($errors)) {
        // Note: No need to convert to null anymore as they are required.
        $success = add_league($db, $league_name, $date_formed, $date_disbanded);
        if ($success) {
            header('Location: leagues.php?added=true');
            exit;
        }
        $errors[] = 'Failed to add league. Please try again.';
    }
}

// Page-specific variables
$pageTitle = 'Add New League';
$contentView = __DIR__ . '/../../views/pages/admin/league_form.php';

// Pass data to the view
$viewData = [
    'formAction' => 'league_add.php',
    'league' => [
        'league_name' => $_POST['league_name'] ?? '',
        'date_formed' => $_POST['date_formed'] ?? '',
        'date_disbanded' => $_POST['date_disbanded'] ?? ''
    ],
    'errors' => $errors
];

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
