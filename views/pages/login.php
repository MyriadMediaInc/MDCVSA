<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDCVSA | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Absolute Paths for Assets -->
  <link rel="stylesheet" href="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="http://13.222.190.11/mdcvsa/public/index.php" class="h1"><b>MDCVSA</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (!empty($errors)) : ?>
          <div class="alert alert-danger">
              <?php foreach ($errors as $error) : ?>
                  <p><?= htmlspecialchars($error) ?></p>
              <?php endforeach; ?>
          </div>
      <?php endif; ?>

      <!-- Absolute URL for form action -->
      <form action="http://13.222.190.11/mdcvsa/public/login.php" method="post">
        <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
      </form>

      <p class="mb-0">
        <!-- Absolute URL for registration link -->
        <a href="http://13.222.190.11/mdcvsa/public/register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- Absolute Paths for Scripts -->
<script src="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="http://13.222.190.11/mdcvsa/public/vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
