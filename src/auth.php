<?php

// src/auth.php

/**
 * Registers a new user.
 *
 * @param PDO $pdo The database connection object.
 * @param string $fullName
 * @param string $email
 * @param string $password
 * @param string $passwordConfirm
 * @return array An array of error messages, or an empty array on success.
 */
function register_user(PDO $pdo, string $fullName, string $email, string $password, string $passwordConfirm): array
{
    $errors = [];

    // 1. Validation
    if (empty($fullName) || empty($email) || empty($password)) {
        $errors[] = 'All fields are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
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

    // 3. Hash password and prepare user data
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Simple split of full name into first and last
    $nameParts = explode(' ', $fullName, 2);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1] ?? ''; // Handle cases with no last name

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