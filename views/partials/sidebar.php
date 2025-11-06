<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL; ?>/public/index.php" class="brand-link">
        <span class="brand-text font-weight-light">MDCVSA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <?php
                    if ($isLoggedIn && $user) {
                        echo htmlspecialchars($user['name']);
                    } else {
                        echo 'Guest / <a href="/mdcvsa/public/login.php">Login</a>';
                    }
                    ?>
                </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/public/index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <li class="nav-header">USER</li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-header">USER</li>
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

                <!-- Show Admin section only if user is logged in and is an admin -->
                <?php if ($isLoggedIn && isset($user['is_admin']) && $user['is_admin']): ?>
                    <li class="nav-header">ADMIN</li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/public/admin/people_list.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>People</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
