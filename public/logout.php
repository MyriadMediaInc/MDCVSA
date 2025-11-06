<?php
// public/logout.php

// Always start the session to access session data.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all of the session variables.
$_SESSION = [];

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Before redirecting, we need to know the BASE_URL.
// We can't use the main bootstrap because it might have dependencies that are not needed here.
// So, we define a simple version of it for this one-off script.
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$base_path = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
$base_url = $protocol . $host . $base_path;

// Redirect to the login page.
header("Location: " . $base_url . '/public/login.php');
exit;
