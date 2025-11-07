<?php

// Master Layout - Assembles the page from partials

// Include the header
require_once __DIR__ . '/../partials/header.php';

// Include the sidebar
require_once __DIR__ . '/../partials/sidebar.php';

// Include the main content for the page
// This will be dynamic in the future, but for now, it's the dashboard
require_once __DIR__ . '/../pages/dashboard.php';

// Include the footer
require_once __DIR__ . '/../partials/footer.php';
