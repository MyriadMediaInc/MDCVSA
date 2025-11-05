<?php

// logout.php

// Start the session
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Redirect to the login page with a logged-out message.
header("Location: login.php?logged_out=true");
exit;
