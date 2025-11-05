<?php

// src/auth.php

/**
 * Registers a new user.
 *
 * @param PDO $pdo The database connection object.
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $password
 * @param string $passwordConfirm
 * @param string $terms
 * @return array An array of error messages, or an empty array on success.
 */
function register_user(PDO $pdo, string $firstName, string $lastName, string $email, string $password, string $passwordConfirm, string $terms): array
{
    $errors = [];

    // 1. Validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $errors[] = 'All fields are required.';
    }

    if ($terms !== 'agree') {
        $errors[] = 'You must agree to the terms and conditions.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Password strength validation
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if (!preg_match('/[a-zA-Z]/', $password)) {
        $errors[] = 'Password must contain at least one letter.';
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = 'Password must contain at least one number.';
    }

    if ($password !== $passwordConfirm) {
        $errors[] = 'Passwords do not match.';
    }

    // 2. Check if user already exists
    $stmt = $pdo->prepare('SELECT id FROM people WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Email address is already in use.';
    }

    // If there are validation errors, return them now.
    if (!empty($errors)) {
        return $errors;
    }

    // 3. Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insert user into the database
    try {
        $sql = "INSERT INTO people (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $passwordHash]);
    } catch (PDOException $e) {
        // Log the real error and return a generic one
        error_log($e->getMessage());
        $errors[] = 'A database error occurred. Please try again later.';
        return $errors;
    }

    return []; // Return empty array for success
}

/**
 * Logs in a user.
 *
 * @param PDO $pdo The database connection object.
 * @param string $email
 * @param string $password
 * @return array An array of error messages, or an empty array on success.
 */
function login_user(PDO $pdo, string $email, string $password): array
{
    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = 'Email and password are required.';
        return $errors;
    }

    // Find the user by email
    $stmt = $pdo->prepare('SELECT id, password FROM people WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user and password
    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = 'Invalid email or password.';
        return $errors;
    }

    // Start session and log user in
    session_start();
    $_SESSION['user_id'] = $user['id'];
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    return []; // Success
}
