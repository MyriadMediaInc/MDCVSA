<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDCVSA | Registration Page</title>

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
<body class="hold-transition register-page">
<div class="register-box" style="width: 460px;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>MDCVSA</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="register.php" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="first_name" placeholder="First name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="last_name" placeholder="Last name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_confirm" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <hr>
        <p class="login-box-msg">Player Information</p>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <input type="text" class="form-control" name="dob" placeholder="Date of Birth (YYYY-MM-DD)" >
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="address_1" placeholder="Address">
           <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="city" placeholder="City">
                   <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-city"></span>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="state" placeholder="State">
                   <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-pin"></span>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="zip_5" placeholder="Zip Code">
           <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-hashtag"></span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="govt_id_image">Government ID Scan</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="govt_id_image" name="govt_id_image">
              <label class="custom-file-label" for="govt_id_image">Choose file</label>
            </div>
          </div>
        </div>


        <div class="row mt-3">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="vendor/almasaeed2010/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<!-- bs-custom-file-input -->
<script src="vendor/almasaeed2010/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
$(function() {
    bsCustomFileInput.init();

    // Check for PHP error messages
    <?php if (!empty($errors)): ?>
        var errorHtml = '<ul class="text-left">' +
            <?php foreach ($errors as $error): ?>
                '<li><?php echo htmlspecialchars($error); ?></li>' +
            <?php endforeach; ?>
        '</ul>';

        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            html: errorHtml,
            confirmButtonText: 'Try Again'
        });
    <?php endif; ?>
});
</script>

</body>
</html>
