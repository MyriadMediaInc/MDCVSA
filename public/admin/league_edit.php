<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/league.php';

$errors = [];
$league_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$league_id) {
    header('Location: leagues.php');
    exit;
}

// Fetch the existing league
$league = get_league_by_id($db, $league_id);

if (!$league) {
    // League not found
    header('Location: leagues.php?error=notfound');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // FIX: Replaced deprecated FILTER_SANITIZE_STRING with FILTER_SANITIZE_FULL_SPECIAL_CHARS
    $league_name = trim(filter_input(INPUT_POST, 'league_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $start_date = trim(filter_input(INPUT_POST, 'start_date'));
    $end_date = trim(filter_input(INPUT_POST, 'end_date'));

    if (empty($league_name)) {
        $errors[] = 'League name is required.';
    }

    if (empty($errors)) {
        $success = update_league($db, $league_id, $league_name, $start_date, $end_date);
        if ($success) {
            // Redirect to the league list with a success message
            header('Location: leagues.php?updated=true');
            exit;
        }
        $errors[] = 'Failed to update league. Please try again.';
    }
    
    // If there was an error, repopulate the league array from POST data to show changes
    $league['league_name'] = $league_name;
    $league['start_date'] = $start_date;
    $league['end_date'] = $end_date;
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
