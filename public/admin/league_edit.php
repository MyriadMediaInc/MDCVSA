<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/league.php';

$errors = [];
// FIX: The primary key column is `league_id`
$league_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$league_id) {
    header('Location: leagues.php');
    exit;
}

// Fetch the existing league
$league = get_league_by_id($db, $league_id);

if (!$league) {
    header('Location: leagues.php?error=notfound');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // FIX: Use correct form field names `date_formed` and `date_disbanded`
    $league_name = trim(filter_input(INPUT_POST, 'league_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $date_formed = trim(filter_input(INPUT_POST, 'date_formed'));
    $date_disbanded = trim(filter_input(INPUT_POST, 'date_disbanded'));

    // Convert empty date strings to null
    $date_formed = $date_formed ?: null;
    $date_disbanded = $date_disbanded ?: null;

    if (empty($league_name)) {
        $errors[] = 'League name is required.';
    }

    if (empty($errors)) {
        // The update_league function now expects the corrected variable names
        $success = update_league($db, $league_id, $league_name, $date_formed, $date_disbanded);
        if ($success) {
            header('Location: leagues.php?updated=true');
            exit;
        }
        $errors[] = 'Failed to update league. Please try again.';
    }
    
    // If there was an error, repopulate the league array from POST data
    $league['league_name'] = $league_name;
    $league['date_formed'] = $date_formed;
    $league['date_disbanded'] = $date_disbanded;
}

// Page-specific variables
$pageTitle = 'Edit League';
$contentView = __DIR__ . '/../../views/pages/admin/league_form.php';

// Pass data to the view
$viewData = [
    'formAction' => 'league_edit.php?id=' . $league_id,
    'league' => $league,
    'errors' => $errors
];

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
