<?php
// Start the session to access session variables
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$user = null;

if ($isLoggedIn) {
    // We need the get_user_by_id function, which is in auth.php
    // and a database connection from bootstrap.php
    require_once __DIR__ . '/../../src/bootstrap.php';
    require_once __DIR__ . '/../../src/auth.php';

    // Check if the get_user_by_id function exists before calling it
    if (function_exists('get_user_by_id')) {
        $user = get_user_by_id($db, $_SESSION['user_id']);
    } else {
        // Handle the error gracefully - maybe log it or show a generic error
        // For now, we'll just ensure the user is not set
        $user = null;
    }
}
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/index.php" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if ($isLoggedIn && $user) : ?>
            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <span class="d-none d-md-inline">Welcome, <?= htmlspecialchars($user['first_name']) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <!-- You might want to add a user image column to your 'people' table -->
                        <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                        <p>
                            <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                            <small>Member Since <?= date("M. Y", strtotime($user['created_at'])) ?></small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="logout.php" class="btn btn-default btn-flat float-right">Logout</a>
                    </li>
                </ul>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
