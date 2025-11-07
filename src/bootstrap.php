<?php

//
// Application Bootstrap
//

// 1. Set up error reporting for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Define a constant for the project's root directory
define('ROOT_PATH', dirname(__DIR__));

// 3. Load Core Application Configuration (like database credentials)
require_once ROOT_PATH . '/config/app.php';

// 4. Register a simple PSR-4 style autoloader
spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'App\\';

    // base directory for the namespace prefix
    $base_dir = ROOT_PATH . '/src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Manually require the Database class as it is foundational and used by models.
// A more advanced setup might use Dependency Injection to provide the database connection.
require_once ROOT_PATH . '/src/Database.php';

?>