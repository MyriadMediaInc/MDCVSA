<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDCVSA | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 460px;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?php echo BASE_URL; ?>/" class="h1"><b>MDCVSA</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p class="mb-0">Please fix the following errors:</p>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
      <?php endif; ?>

      <form action="<?php echo BASE_URL; ?>/public/register.php" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="first_name" placeholder="First name" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="last_name" placeholder="Last name" required value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_confirm" placeholder="Retype password" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        
        <hr>
        <p class="login-box-msg">Personal Information</p>

        <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            <input type="text" class="form-control" name="dob" placeholder="Date of Birth (YYYY-MM-DD)" required value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
            <input type="tel" class="form-control" name="phone" placeholder="Phone Number (Optional)" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="address_1" placeholder="Street Address" required value="<?php echo htmlspecialchars($_POST['address_1'] ?? ''); ?>">
           <div class="input-group-append"><div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="address_2" placeholder="Apartment, Suite, Unit, etc. (Optional)" value="<?php echo htmlspecialchars($_POST['address_2'] ?? ''); ?>">
           <div class="input-group-append"><div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="city" placeholder="City" required value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
           <div class="input-group-append"><div class="input-group-text"><span class="fas fa-city"></span></div></div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="state" placeholder="State" required value="<?php echo htmlspecialchars($_POST['state'] ?? ''); ?>">
                   <div class="input-group-append"><div class="input-group-text"><span class="fas fa-map-pin"></span></div></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="zip_5" placeholder="Zip Code" required value="<?php echo htmlspecialchars($_POST['zip_5'] ?? ''); ?>">
                   <div class="input-group-append"><div class="input-group-text"><span class="fas fa-hashtag"></span></div></div>
                </div>
            </div>
        </div>
         <div class="input-group mb-3">
          <input type="text" class="form-control" name="zip_4" placeholder="Zip+4 (Optional)" value="<?php echo htmlspecialchars($_POST['zip_4'] ?? ''); ?>">
           <div class="input-group-append"><div class="input-group-text"><span class="fas fa-hashtag"></span></div></div>
        </div>


        <div class="form-group">
          <label for="govt_id_image">Government ID Scan (Optional)</label>
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

      <a href="<?php echo BASE_URL; ?>/public/login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
$(function() {
    bsCustomFileInput.init();

    // Check for PHP error messages passed from the controller
    <?php if (!empty($errors)): ?>
        // This block is no longer needed if using the inline display method above
    <?php endif; ?>
});
</script>

</body>
</html>
