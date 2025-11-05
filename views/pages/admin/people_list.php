<?php
// The AdminLTE header and sidebar would typically be included here.
// For this example, we'll create a self-contained page.
// We assume the user is authenticated as an admin.

include __DIR__ . '/../shared/admin_header.php';
include __DIR__ . '/../shared/admin_sidebar.php';
?>

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
                        <li class="breadcrumb-item"><a href="/admin/dashboard.php">Home</a></li>
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
                                <a href="/register.php" class="btn btn-success">
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
// Assumes a shared footer file that includes all the necessary JS
include __DIR__ . '/../shared/admin_footer.php';
?>

<!-- Page specific scripts -->
<script>
$(function () {
    var table = $('#peopleTable').DataTable({
        // --- Server-Side Processing --- 
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/api/get_people.php",
            "type": "POST"
        },

        // --- Column Definitions ---
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
                "data": "id", // Use the ID for the action buttons
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    // NOTE: The links for view/edit are placeholders for now
                    return `
                        <a href="/admin/person_view.php?id=${data}" class="btn btn-xs btn-primary" title="View"><i class="fas fa-eye"></i></a>
                        <a href="/admin/person_edit.php?id=${data}" class="btn btn-xs btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-xs btn-danger" title="Delete" onclick="deletePerson(${data})"><i class="fas fa-trash"></i></a>
                    `;
                }
            }
        ],

        // --- Layout & Features ---
        "paging": true,
        "lengthChange": true,
        "searching": true, // Note: This is the simple filter box. SearchBuilder provides the advanced one.
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "dom": 'QBfrtip', // Q=SearchBuilder, B=Buttons, f=filtering input, r=processing display, t=table, i=info, p=pagination
        
        // --- Buttons & Export ---
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
        ],

        // --- SearchBuilder (Enhanced Search) ---
        "searchBuilder": {
             // Logic to add League and Team will be added later
        }
    });
});

// Placeholder for a delete function
function deletePerson(id) {
    if(confirm('Are you sure you want to delete person #' + id + '?')) {
        // AJAX call to a delete script would go here
        console.log('Deleting person', id);
        // E.g., $.post('/api/delete_person.php', { id: id }, ...);
        // On success, you would reload the table: $('#peopleTable').DataTable().ajax.reload();
    }
}

</script>

</body>
</html>
