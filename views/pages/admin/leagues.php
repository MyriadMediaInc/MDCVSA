<?php
// This file is included by a "controller" file, which has already started the session and set up the database connection.
// The controller also defines the $leagues variable.
?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
    <div class="alert alert-success" role="alert">
        League successfully deleted.
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Leagues</h3>
        <div class="card-tools">
            <a href="league_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New League
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leagues)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No leagues found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($leagues as $league): ?>
                        <tr>
                            <td><?= htmlspecialchars($league['id']) ?></td>
                            <td><?= htmlspecialchars($league['name']) ?></td>
                            <td><?= htmlspecialchars(date('M j, Y', strtotime($league['start_date']))) ?></td>
                            <td><?= htmlspecialchars(date('M j, Y', strtotime($league['end_date']))) ?></td>
                            <td>
                                <a href="league_edit.php?id=<?= $league['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                <form action="leagues.php" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="delete_id" value="<?= $league['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this league?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
