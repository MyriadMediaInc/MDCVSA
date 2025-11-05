<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$user = null;

if ($isLoggedIn) {
    // The user object is needed. Ensure bootstrap and auth functions are available.
    // A more advanced structure would use a service container or a session class to manage the user object.
    require_once __DIR__ . '/../../src/bootstrap.php';
    require_once __DIR__ . '/../../src/auth.php';

    if (function_exists('get_user_by_id')) {
        $user = get_user_by_id($db, $_SESSION['user_id']);
    } 
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/mdcvsa/index.php" class="brand-link">
        <span class="brand-text font-weight-light">MDCVSA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php if ($isLoggedIn && $user): ?>
                <div class="image">
                    <!-- We'll use a default image for now, with standard AdminLTE classes -->
                    <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></a>
                </div>
            <?php else: ?>
                <div class="info">
                    <a href="login.php" class="d-block">Guest User</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/mdcvsa/index.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php if (!$isLoggedIn): ?>
                <li class="nav-item">
                    <a href="/mdcvsa/register.php" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Register</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/mdcvsa/login.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>Login</p>
                    </a>
                </li>
                <?php endif; ?>
                 <?php if ($isLoggedIn): ?>
                <li class="nav-item">
                    <a href="/mdcvsa/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
