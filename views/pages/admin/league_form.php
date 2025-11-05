<?php
// This view is included by a controller (league_add.php or league_edit.php)
// The following variables are expected to be set by the controller:
// $viewData['errors'] (array of error messages)
// $viewData['formAction'] (the URL the form should submit to)
// $viewData['league'] (array of league data for pre-filling the form)

$errors = $viewData['errors'] ?? [];
$formAction = $viewData['formAction'] ?? '';
$league = $viewData['league'] ?? [];
$pageTitle = $pageTitle ?? 'League Form'; // Fallback title

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
                <label for="date_formed">Date Formed</label>
                <!-- FIX: Added `required` attribute -->
                <input type="date" class="form-control" id="date_formed" name="date_formed" value="<?= htmlspecialchars($league['date_formed'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="date_disbanded">Date Disbanded</label>
                <!-- FIX: Added `required` attribute -->
                <input type="date" class="form-control" id="date_disbanded" name="date_disbanded" value="<?= htmlspecialchars($league['date_disbanded'] ?? '') ?>" required>
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
