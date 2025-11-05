<?php
// admin/people_list.php

require_once __DIR__ . '/../src/bootstrap.php';

// Here you would typically have a check to ensure the user is an admin.
// For example:
// if (!is_admin()) {
//     header('Location: /login.php');
//     exit();
// }

// The view file will contain all the presentation logic.
include __DIR__ . '/../views/pages/admin/people_list.php';
