<?php

// views/pages/registration-success.php

?>

<div class="row">
    <div class="col-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle"></i> Registration Successful!</h3>
            </div>
            <div class="card-body">
                <p class="lead">Thank you for registering, <?= htmlspecialchars($user['first_name']) ?>. Your membership is now active.</p>
                <p>A confirmation email has been sent to <strong><?= htmlspecialchars($user['email']) ?></strong>. Please check your inbox to complete the verification process.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Registration Summary</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Full Name</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></dd>

                    <dt class="col-sm-4">Email Address</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($user['email']) ?></dd>

                    <dt class="col-sm-4">Date of Birth</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($player['dob'] ?? 'N/A') ?></dd>

                    <dt class="col-sm-4">Mailing Address</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($player['address_1'] ?? 'N/A') ?></dd>

                    <dt class="col-sm-4">City, State, Zip</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars(($player['city'] ?? 'N/A') . ', ' . ($player['state'] ?? 'N/A') . ' ' . ($player['zip_5'] ?? 'N/A')) ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registration Receipt</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td>Annual Membership Fee:</td>
                            <td class="text-right">$50.00</td>
                        </tr>
                        <tr>
                            <td>Processing Fee:</td>
                            <td class="text-right">$2.50</td>
                        </tr>
                        <tr>
                            <th style="border-top: 2px solid #dee2e6;">Total Paid:</th>
                            <th class="text-right" style="border-top: 2px solid #dee2e6;">$52.50</th>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center mt-3 no-print">
                    <button onclick="window.print();" class="btn btn-default"><i class="fas fa-print"></i> Print Receipt</button>
                    <a href="index.php" class="btn btn-primary mt-2 mt-md-0">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
