<?php
// This view is included by public/admin/leagues.php
// It expects a variable $viewData['leagues'] to be an array of league data.
$leagues = $viewData['leagues'] ?? [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Leagues</h3>
        <div class="card-tools">
            <a href="league_add.php" class="btn btn-primary btn-sm">Add New League</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <?php if (isset($_GET['added'])): ?>
            <div class="alert alert-success">League added successfully!</div>
        <?php elseif (isset($_GET['updated'])): ?>
            <div class="alert alert-success">League updated successfully!</div>
        <?php elseif (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">League deleted successfully!</div>
        <?php elseif (isset($_GET['error'])):
            $errorMessage = 'An error occurred.';
            if ($_GET['error'] === 'deletefailed') {
                $errorMessage = 'Failed to delete the league. It might be in use or an error occurred.';
            } elseif ($_GET['error'] === 'notfound') {
                $errorMessage = 'The requested league was not found.';
            }
            ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Date Formed</th>
                    <th>Date Disbanded</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leagues)):
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">No leagues found.</td>
                    </tr>
                <?php
                else:
                    ?>
                    <?php foreach ($leagues as $league):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($league['league_id']) ?></td>
                            <td><?= htmlspecialchars($league['league_name']) ?></td>
                            <td><?= htmlspecialchars($league['date_formed'] ? date('M j, Y', strtotime($league['date_formed'])) : 'N/A') ?></td>
                            <td><?= htmlspecialchars($league['date_disbanded'] ? date('M j, Y', strtotime($league['date_disbanded'])) : 'N/A') ?></td>
                            <td>
                                <a href="league_edit.php?id=<?= $league['league_id'] ?>" class="btn btn-info btn-xs">Edit</a>
                                <!-- FIX: Modified button to trigger modal -->
                                <button type="button" class="btn btn-danger btn-xs" 
                                        data-toggle="modal" 
                                        data-target="#confirmDeleteModal" 
                                        data-href="leagues.php?action=delete&id=<?= $league['league_id'] ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php
                    endforeach; ?>
                <?php
                endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
