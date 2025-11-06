<?php
// public/register.php

require_once __DIR__ . '/../src/bootstrap.php';

// This is the entry point for the registration page.
// It boots the application and then includes the view logic.

// Logic to handle form submission would go here in a real application.
// For now, we are just displaying the form.
$errors = []; // Initialize an empty errors array for the view to use.

// Include the view file which contains the HTML markup.
// The BASE_URL constant is now available for it to use.
include __DIR__ . '/../views/pages/register.php';
