<?php
// This sidebar partial now relies on the main app.php layout to provide the following variables:
// - $isLoggedIn (boolean)
// - $user (array|null)
// - BASE_URL (string)
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL; ?>/public/index.php" class="brand-link">
        <span class="brand-text font-weight-light">MDCVSA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php if ($isLoggedIn && $user): ?>
                <div class="image">
                    <!-- Using a generic user icon for now -->
                    <img src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></a>
                </div>
            <?php else: ?>
                <div class="info">
                    <a href="<?php echo BASE_URL; ?>/public/login.php" class="d-block">Guest / Login</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/public/index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if ($isLoggedIn && isset($user['is_admin']) && $user['is_admin'] == 1): ?>
                    <li class="nav-header">ADMINISTRATION</li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/admin/leagues.php" class="nav-link">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>Leagues</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/admin/people_list.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>People</p>
                        </a>
                    </li>
                 <?php endif; ?>

                 <li class="nav-header">USER</li>
                 <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/register.php" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Register</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/login.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>Login</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
