<?php
// Centralized bootstrap and authentication logic.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Composer autoloader, environment variables, and core functions.
require_once __DIR__ . '/../../src/bootstrap.php';

$db = null;
$db_error = null;
try {
    // Correctly instantiate the Database class using its fully qualified namespace.
    $db = (new App\Database())->getConnection();
} catch (Exception $e) {
    $db_error = 'Database Connection Error: ' . $e->getMessage();
}

// Load authentication functions.
require_once __DIR__ . '/../../src/auth.php';

$isLoggedIn = false;
$user = null;
if ($db && !$db_error) {
    $isLoggedIn = isset($_SESSION['user_id']);
    if ($isLoggedIn) {
        $user = get_user_by_id($db, $_SESSION['user_id']);
    }
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
    
    <!-- **DEFINITIVE FIX**: Use the new, real asset path. -->
    <link rel="stylesheet" href="http://13.222.190.11/mdcvsa/public/assets/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://13.222.190.11/mdcvsa/public/assets/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include __DIR__ . '/../partials/header.php'; ?>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php
        if ($db_error) {
            echo '<div class="container-fluid"><div class="alert alert-danger"><strong>Fatal Error:</strong> ' . htmlspecialchars($db_error) . '</div></div>';
        } else if (!isset($contentView) || !file_exists($contentView)) {
            echo '<div class="container-fluid"><div class="alert alert-danger"><strong>Error:</strong> Page content not found.</div></div>';
        } else {
            include $contentView;
        }
        ?>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- **DEFINITIVE FIX**: Use the new, real asset path. -->
<script src="http://13.222.190.11/mdcvsa/public/assets/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="http://13.222.190.11/mdcvsa/public/assets/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="http://13.222.190.11/mdcvsa/public/assets/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
