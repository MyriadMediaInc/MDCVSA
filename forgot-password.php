<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config/database.php';

$mail_config = require 'config/mail.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        $error = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate a secure token
            $token = bin2hex(random_bytes(50));
            // Set an expiration date (e.g., 1 hour from now)
            $expires = new DateTime('now');
            $expires->add(new DateInterval('PT1H'));

            // Store the token and expiration date in the database
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
            $stmt->execute([$token, $expires->format('Y-m-d H:i:s'), $user['id']]);

            // Send the password reset email
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = $mail_config['host'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $mail_config['username'];
                $mail->Password   = $mail_config['password'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = $mail_config['port'];

                //Recipients
                $mail->setFrom($mail_config['from_address'], $mail_config['from_name']);
                $mail->addAddress($user['email']);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;
                $mail->Body    = "Hello,<br><br>Someone has requested a link to change your password. You can do this through the link below.<br><br>" .
                                 "<a href='" . $reset_link . "'>Change my password</a><br><br>" .
                                 "If you didn't request this, please ignore this email.<br><br>" .
                                 "Your password won't change until you access the link above and create a new one.";

                $mail->send();
                $message = 'If an account with that email exists, a password reset link has been sent.';
            } catch (Exception $e) {
                // Don't expose detailed errors to the user
                $error = "Message could not be sent. Please try again later.";
            }
        } else {
          // Even if the user is not found, we show the same message for security reasons
          $message = 'If an account with that email exists, a password reset link has been sent.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDCVSA | Forgot Password</title>

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
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="forgot-password.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="login.php">Login</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
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
            title: 'Request Sent',
            text: '<?php echo htmlspecialchars($message); ?>',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo htmlspecialchars($error); ?>',
            confirmButtonText: 'Try Again'
        });
    <?php endif; ?>
});
</script>

</body>
</html>
