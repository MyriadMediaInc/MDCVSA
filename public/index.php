<?php

// Basic bootstrap
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

// Page-specific variables
$pageTitle = 'Dashboard';
$contentView = __DIR__ . '/../views/pages/dashboard.php';

// Render the layout
include __DIR__ . '/../views/layouts/app.php';
