<?php
// public/admin/person_edit.php

$person = null;
$error_message = '';
$success_message = '';

// 1. Get the ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $error_message = 'No person ID provided or invalid ID.';
} else {
    $person_id = (int)$_GET['id'];
    // 2. Fetch the person from the database
    $person = get_user_by_id($db, $person_id);

    if (!$person) {
        $error_message = "A person with ID {$person_id} could not be found.";
    }
}

// 3. Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $person) {
    // Sanitize and prepare data from the form
    $update_data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'dob'        => trim($_POST['dob'] ?? ''),
        'status'     => trim($_POST['status'] ?? ''),
    ];

    // The update_user function is now in auth.php
    $result = update_user($db, $person_id, $update_data);

    if ($result === true) {
        // Success! Set a success message and re-fetch the user data to show the updated info.
        $success_message = 'User profile updated successfully!';
        $person = get_user_by_id($db, $person_id); // Refresh data
    } else {
        // If update_user returned an array of errors, format them.
        $error_message = 'There were errors updating the profile: <ul><li>' . implode('</li><li>', $result) . '</li></ul>';
    }
}

// 4. Set page variables
if ($person) {
    $pageTitle = 'Edit Person: ' . htmlspecialchars($person['first_name'] . ' ' . $person['last_name']);
} else {
    $pageTitle = 'Error';
}

// Data to pass to the view
$viewData = [
    'person'          => $person,
    'error_message'   => $error_message,
    'success_message' => $success_message,
];

$contentView = __DIR__ . '/../../../views/pages/admin/person_edit.php';

// 5. Include the main layout
include __DIR__ . '/../../../views/layouts/app.php';
