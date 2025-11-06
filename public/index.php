<?php
// public/index.php (Main Dashboard)

// Page-specific variables
$pageTitle = 'Dashboard';
$contentView = __DIR__ . '/../views/pages/dashboard.php';

// The main app layout will handle all session, authentication, and bootstrap logic.
// It will also handle redirecting to login if the user is not authenticated.
include __DIR__ . '/../views/layouts/app.php';
