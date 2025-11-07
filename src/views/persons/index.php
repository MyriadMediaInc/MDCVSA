<?php
// This is a placeholder for the datatable view.
// We will populate this with the HTML structure for the user table.
?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Registered Users</h5>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($persons as $person): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($person['first_name']) . ' ' . htmlspecialchars($person['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($person['email']); ?></td>
                        <td><?php echo htmlspecialchars($person['city']); ?></td>
                        <td><?php echo htmlspecialchars($person['state_code']); ?></td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                            <a href="#" class="btn btn-secondary btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
