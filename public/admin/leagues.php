<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/league.php';

// Handle the delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $league_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($league_id && delete_league($db, $league_id)) {
        header('Location: leagues.php?deleted=true');
        exit;
    }
    header('Location: leagues.php?error=deletefailed');
    exit;
}

// Fetch all leagues
$leagues = get_all_leagues($db);

// Page-specific variables
$pageTitle = 'Manage Leagues';
$contentView = __DIR__ . '/../../views/pages/admin/leagues_list.php';

// The view needs access to the leagues
$viewData = ['leagues' => $leagues];

// Render the layout and pass data to it
include __DIR__ . '/../../views/layouts/app.php';
