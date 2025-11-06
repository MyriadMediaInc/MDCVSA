<?php
// public/admin/people_list.php

// This is the controller file for the people list page.
// It ensures the application is bootstrapped and makes the BASE_URL available.

require_once __DIR__ . '/../../../src/bootstrap.php';

// Include the main view file for the people list.
// This file contains the complete HTML document structure.
include __DIR__ . '/../../../views/pages/admin/people_list.php';
