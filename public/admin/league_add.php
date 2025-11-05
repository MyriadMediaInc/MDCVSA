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
    // FIX: Use correct form field names `date_formed` and `date_disbanded`
    $league_name = trim(filter_input(INPUT_POST, 'league_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $date_formed = trim(filter_input(INPUT_POST, 'date_formed'));
    $date_disbanded = trim(filter_input(INPUT_POST, 'date_disbanded'));

    // Convert empty date strings to null for proper database insertion.
    $date_formed = $date_formed ?: null;
    $date_disbanded = $date_disbanded ?: null;

    if (empty($league_name)) {
        $errors[] = 'League name is required.';
    }

    if (empty($errors)) {
        // The add_league function now expects the corrected variable names
        $league_id = add_league($db, $league_name, $date_formed, $date_disbanded);
        if ($league_id) {
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
        // FIX: Pre-fill form with correct field names on error
        'league_name' => $_POST['league_name'] ?? '',
        'date_formed' => $_POST['date_formed'] ?? '',
        'date_disbanded' => $_POST['date_disbanded'] ?? ''
    ],
    'errors' => $errors
];

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
