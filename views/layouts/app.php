<?php
// Centralized bootstrap and authentication logic.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load core application logic, database class, and BASE_URL.
require_once __DIR__ . '/../../src/bootstrap.php';

// **FIX**: Establish the database connection here to make it globally available to the layout and all included pages.
// This solves the 500 Internal Server Error on all pages that use this layout.
$db = (new Database())->getConnection();

// Load authentication functions AFTER the database connection is available.
require_once __DIR__ . '/../../src/auth.php';

// Globally check login status and fetch user data for header/sidebar.
$isLoggedIn = isset($_SESSION['user_id']);
$user = null;
if ($isLoggedIn) {
    $user = get_user_by_id($db, $_SESSION['user_id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ?? 'MDCVSA Admin'; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <!-- **FIX**: Corrected asset paths to use the 'vendor' symlink. -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include __DIR__ . '/../partials/header.php'; ?>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php
        if (!isset($contentView) || !file_exists($contentView)) {
            echo '<div class="container-fluid"><div class="alert alert-danger"><strong>Error:</strong> Page content not found.</div></div>';
        } else {
            if (isset($viewData) && is_array($viewData)) {
                extract($viewData);
            }
            include $contentView;
        }
        ?>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- **FIX**: Corrected script paths to use the 'vendor' symlink. -->
<!-- jQuery -->
<script src="<?php echo BASE_URL; ?>/public/vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo BASE_URL; ?>/public/vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL; ?>/public/vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
