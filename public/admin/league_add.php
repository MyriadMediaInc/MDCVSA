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
    // FIX: Replaced deprecated FILTER_SANITIZE_STRING with FILTER_SANITIZE_FULL_SPECIAL_CHARS
    $league_name = trim(filter_input(INPUT_POST, 'league_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $start_date = trim(filter_input(INPUT_POST, 'start_date'));
    $end_date = trim(filter_input(INPUT_POST, 'end_date'));

    if (empty($league_name)) {
        $errors[] = 'League name is required.';
    }

    if (empty($errors)) {
        $league_id = add_league($db, $league_name, $start_date, $end_date);
        if ($league_id) {
            // Redirect to the league list with a success message
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
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? ''
    ],
    'errors' => $errors
];

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
