<?php
// views/pages/admin/person_view.php

// The controller (public/admin/person_view.php) has already fetched the $person data.

include __DIR__ . '/../../partials/header.php';
include __DIR__ . '/../../partials/sidebar.php';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile: <?= htmlspecialchars($person['first_name'] . ' ' . $person['last_name']) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/mdcvsa/public/admin/dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="/mdcvsa/public/admin/people_list.php">People</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Personal Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">First Name</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['first_name']) ?></dd>

                                <dt class="col-sm-4">Last Name</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['last_name']) ?></dd>

                                <dt class="col-sm-4">Email Address</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['email']) ?></dd>

                                <dt class="col-sm-4">Date of Birth</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['dob']) ?></dd>

                                <dt class="col-sm-4">Primary Address</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['address_1']) ?></dd>

                                <dt class="col-sm-4">Secondary Address</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['address_2'] ?? 'N/A') ?></dd>

                                <dt class="col-sm-4">City</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['city']) ?></dd>

                                <dt class="col-sm-4">State</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['state']) ?></dd>

                                <dt class="col-sm-4">Zip Code</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['zip']) ?></dd>

                                <dt class="col-sm-4">Phone Number</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($person['phone']) ?></dd>
                            </dl>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                             <a href="/mdcvsa/public/admin/person_edit.php?id=<?= $person['id'] ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                             <a href="/mdcvsa/public/admin/people_list.php" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-3">
                     <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="https://adminlte.io/themes/v3/dist/img/user4-128x128.jpg" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= htmlspecialchars($person['first_name'] . ' ' . $person['last_name']) ?></h3>

                            <p class="text-muted text-center">Member</p> <!-- Placeholder for role -->

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> 
                                    <span class="float-right badge badge-success"><?= htmlspecialchars(ucfirst($person['status'])) ?></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Member Since</b> <a class="float-right"><?= date('M j, Y', strtotime($person['created_at'])) ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Leagues</b> <a class="float-right">0</a> <!-- Placeholder -->
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include __DIR__ . '/../../partials/footer.php';
?>
