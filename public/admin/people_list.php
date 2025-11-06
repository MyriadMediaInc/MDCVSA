<?php
// public/admin/people_list.php
// This controller now only needs to define the page title and the content view.
// All bootstrapping and authentication is handled by the main app layout.

$pageTitle = 'Manage People';
$contentView = __DIR__ . '/../../../views/pages/admin/people_list.php';

// The app.php layout will handle the rest.
include __DIR__ . '/../../../views/layouts/app.php';
