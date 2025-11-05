<?php
// This view is included by a controller (league_add.php or league_edit.php)
// The following variables are expected to be set by the controller:
// $errors (array of error messages)
// $formAction (the URL the form should submit to)
// $league (array of league data for pre-filling the form)
// $pageTitle (the title of the page)

$submitButtonText = (strpos($formAction, 'edit') !== false) ? 'Update League' : 'Create League';

?>

<?php if (!empty($errors)):
    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Oh snap!</strong>
        <ul>
            <?php foreach ($errors as $error):
                ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php
            endforeach; ?>
        </ul>
    </div>
<?php
endif; ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= htmlspecialchars($pageTitle) ?></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="league_name">League Name</label>
                <input type="text" class="form-control" id="league_name" name="league_name" placeholder="Enter league name" value="<?= htmlspecialchars($league['league_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($league['start_date'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($league['end_date'] ?? '') ?>">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><?= $submitButtonText ?></button>
            <a href="leagues.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<!-- /.card -->
