<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/league.php';

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = filter_input(INPUT_POST, 'delete_id', FILTER_SANITIZE_NUMBER_INT);
    if ($delete_id) {
        delete_league($db, $delete_id);
        // Redirect to avoid re-deleting on refresh
        header('Location: leagues.php?deleted=true');
        exit;
    }
}

// Fetch all leagues
$leagues = get_all_leagues($db);

// Page-specific variables
$pageTitle = 'Manage Leagues';
$contentView = __DIR__ . '/../../views/pages/admin/leagues.php';

// Render the layout
include __DIR__ . '/../../views/layouts/app.php';
