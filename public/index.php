<?php

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
