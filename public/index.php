<?php

// Load Core Application Configuration
require_once __DIR__ . '/../config/app.php';

// Load Database Configuration and Connection
require_once __DIR__ . '/../src/Database.php';


// For now, we will just load the main layout
// Later, this will be handled by a router
require_once __DIR__ . '/../src/views/layouts/main.php';
