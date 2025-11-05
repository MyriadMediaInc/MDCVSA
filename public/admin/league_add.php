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
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $start_date = trim(filter_input(INPUT_POST, 'start_date'));
    $end_date = trim(filter_input(INPUT_POST, 'end_date'));

    if (empty($name)) {
        $errors[] = 'League name is required.';
    }

    if (empty($errors)) {
        $league_id = add_league($db, $name, $start_date, $end_date);
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
$contentView = __DIR__ . '/../../views/pages/admin/league_form.php'; // We can reuse a single form for add/edit

// We need to pass some variables to the view
$formAction = 'league_add.php';
$formMethod = 'POST';
$league = [
    'name' => $_POST['name'] ?? '',
    'start_date' => $_POST['start_date'] ?? '',
    'end_date' => $_POST['end_date'] ?? ''
]; // for pre-filling form on error

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
