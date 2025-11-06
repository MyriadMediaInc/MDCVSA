<?php
// views/pages/admin/people_list.php

// The controller includes bootstrap.php, so BASE_URL is available.

// Include the site header and sidebar, which contain the start of the HTML document structure.
include __DIR__ . '/../../partials/header.php';
include __DIR__ . '/../../partials/sidebar.php';

?>
<!-- This page-specific CSS will be loaded in the <head> which is in header.php -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>People</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/public/admin/dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">People List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registered People</h3>
                            <div class="card-tools">
                                <a href="<?php echo BASE_URL; ?>/public/register.php" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Add New Person
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="peopleTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include the site footer
include __DIR__ . '/../../partials/footer.php';
?>

<!-- PAGE-SPECIFIC PLUGINS -->
<!-- DataTables & Plugins -->
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo BASE_URL; ?>/vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page-specific script -->
<script>
$(function () {
    var table = $('#peopleTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo BASE_URL; ?>/api/get_people.php",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "email" },
            { "data": "dob" },
            { "data": "address_1" },
            { "data": "city" },
            { "data": "state" },
            {
                "data": "status",
                "render": function(data, type, row) {
                    let badgeClass = 'badge-secondary';
                    if (data === 'active') badgeClass = 'badge-success';
                    if (data === 'suspended') badgeClass = 'badge-warning';
                    if (data === 'inactive') badgeClass = 'badge-danger';
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            {
                "data": "created_at",
                "render": function(data, type, row) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                "data": "id",
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    return `
                        <a href="<?php echo BASE_URL; ?>/public/admin/person_view.php?id=${data}" class="btn btn-xs btn-primary" title="View"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo BASE_URL; ?>/public/admin/person_edit.php?id=${data}" class="btn btn-xs btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-xs btn-danger" title="Delete" onclick="deletePerson(${data})"><i class="fas fa-trash"></i></a>
                    `;
                }
            }
        ]
    }).buttons().container().appendTo('#peopleTable_wrapper .col-md-6:eq(0)');
});

function deletePerson(id) {
    if(confirm('Are you sure you want to delete person #' + id + '?')) {
        console.log("Attempting to delete person: ", id);
    }
}
</script>
