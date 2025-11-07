<?php

// 1. Bootstrap the Application
// This initializes error reporting, constants, and the autoloader.
require_once __DIR__ . '/../src/bootstrap.php';

// 2. Render the Page Layout

// Include Header
require_once ROOT_PATH . '/src/views/partials/header.php';

// Include Sidebar
require_once ROOT_PATH . '/src/views/partials/sidebar.php';

?>

<!--  Main wrapper -->
<div class="body-wrapper">
    <!--  Header Start -->
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/mdcvsa/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-user fs-6"></i>
                                    <p class="mb-0 fs-3">My Profile</p>
                                </a>
                                <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--  Header End -->

    <div class="container-fluid">
        <?php
        // 3. Route the Request
        $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
        $path = str_replace('/mdcvsa', '', $request_uri);
        if (empty($path)) {
            $path = '/';
        }

        switch ($path) {
            case '/':
            case '/dashboard':
                include ROOT_PATH . '/src/views/pages/dashboard.php';
                break;

            case '/persons':
                $controller = new App\Controllers\PersonController();
                $controller->index();
                break;

            default:
                // A simple 404 handler
                http_response_code(404);
                echo "<p>Page not found for path: " . htmlspecialchars($path) . "</p>";
                break;
        }
        ?>
    </div>
</div>

<?php

// Include Footer
require_once ROOT_PATH . '/src/views/partials/footer.php';

?>
