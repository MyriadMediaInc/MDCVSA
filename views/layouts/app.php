<?php
// Centralized bootstrap and authentication logic.
// This is the single source of truth for application setup.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load core application logic, database, BASE_URL, and auth functions.
// This makes them globally available to all pages that use this layout.
require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/auth.php';

// Globally check login status and fetch user data for header/sidebar.
$isLoggedIn = isset($_SESSION['user_id']);
$user = null;
if ($isLoggedIn) {
    // The get_user_by_id function and $db variable come from the files required above.
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/assets/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/assets/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- The header and sidebar partials will now have access to the variables defined above -->
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php
        // The content view is included by the individual page controllers (e.g., public/index.php)
        // That controller is responsible for setting the $contentView variable.
        if (!isset($contentView) || !file_exists($contentView)) {
            echo '<div class="container-fluid"><div class="alert alert-danger"><strong>Error:</strong> Page content not found.</div></div>';
        } else {
            // If the controller passed any view-specific data, extract it so the view can use it.
            if (isset($viewData) && is_array($viewData)) {
                extract($viewData);
            }
            include $contentView;
        }
        ?>
    </div>
    <!-- /.content-wrapper -->

    <?php include __DIR__ . '/../partials/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo BASE_URL; ?>/public/assets/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo BASE_URL; ?>/public/assets/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL; ?>/public/assets/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
