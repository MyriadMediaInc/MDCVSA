<?php
require 'config/Database.php'; // Corrected path

$token = $_GET['token'] ?? '';
$message = '';
$error = '';

if (empty($token)) {
    $error = "No reset token provided. Please use the link from your email.";
} else {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // Look up the user by the reset token
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $error = "Invalid or expired token. Please request a new password reset.";
    } else {
        // Check if the token has expired
        $expiryDate = new DateTime($user['reset_token_expires_at']);
        $now = new DateTime();

        if ($now > $expiryDate) {
            $error = "This password reset link has expired. Please request a new one.";
        } else {
            // Handle the form submission for password change
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $password_confirm = $_POST['password_confirm'] ?? '';

                if (empty($password) || empty($password_confirm)) {
                    $error = "Please enter and confirm your new password.";
                } elseif ($password !== $password_confirm) {
                    $error = "The passwords do not match.";
                } elseif (strlen($password) < 8) {
                    $error = "Password must be at least 8 characters long.";
                } else {
                    // Hash the new password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Update the user's password and clear the reset token
                    $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
                    $stmt->execute([$hashed_password, $user['id']]);

                    $message = "Your password has been successfully updated. You can now log in with your new password.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDCVSA | Reset Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>MDCVSA</b></a>
    </div>
    <div class="card-body">
      <?php if (empty($message) && empty($error)): ?>
        <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
        <form action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_confirm" placeholder="Confirm Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Change password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      <?php endif; ?>
      <p class="mt-3 mb-1">
        <a href="login.php">Login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="vendor/almasaeed2010/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>

<script>
$(function() {
    <?php if (!empty($message)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Password Changed',
            text: '<?php echo htmlspecialchars($message); ?>',
            confirmButtonText: 'Login'
        }).then(function () {
            window.location.href = 'login.php';
        });
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo htmlspecialchars($error); ?>',
            confirmButtonText: 'Try Again'
        }).then(function () {
            // Optional: Redirect to the forgot password page on error
            window.location.href = 'forgot-password.php';
        });
    <?php endif; ?>
});
</script>

</body>
</html>
