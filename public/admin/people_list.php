<?php
// public/admin/people_list.php

require_once __DIR__ . '/../../src/bootstrap.php';

// Admin access check (placeholder)
// if (!is_admin()) {
//     header('Location: /mdcvsa/login.php');
//     exit();
// }

// Include the view file from the correct path
include __DIR__ . '/../../views/pages/admin/people_list.php';
