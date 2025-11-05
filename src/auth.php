<?php

// src/auth.php

/**
 * Registers a new user with extended player information and ID upload.
 *
 * @param PDO $pdo The database connection object.
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $password
 * @param string $passwordConfirm
 * @param string $terms
 * @param string|null $dob
 * @param string|null $address1
 * @param string|null $city
 * @param string|null $state
 * @param string|null $zip5
 * @param array|null $govt_id_image
 * @return array An array of error messages, or an empty array on success.
 */
function register_user(
    PDO $pdo,
    string $firstName,
    string $lastName,
    string $email,
    string $password,
    string $passwordConfirm,
    string $terms,
    ?string $dob,
    ?string $address1,
    ?string $city,
    ?string $state,
    ?string $zip5,
    ?array $govt_id_image
): array {
    $errors = [];

    // --- 1. Standard Validation ---
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $errors[] = 'First Name, Last Name, Email, and Password are required.';
    }
    if ($terms !== 'agree') {
        $errors[] = 'You must agree to the terms and conditions.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }
    if (strlen($password) < 8 || !preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)) {
        $errors[] = 'Password must be at least 8 characters long and include at least one letter and one number.';
    }
    if ($password !== $passwordConfirm) {
        $errors[] = 'Passwords do not match.';
    }
    
    // --- 2. New Field Validation (optional fields) ---
    if (!empty($dob) && !DateTime::createFromFormat('Y-m-d', $dob)) {
        $errors[] = 'Invalid Date of Birth format. Please use YYYY-MM-DD.';
    }

    // --- 3. Check for existing user ---
    $stmt = $pdo->prepare('SELECT id FROM people WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Email address is already in use.';
    }

    // --- 4. Handle File Upload ---
    $id_image_path = null;
    if ($govt_id_image && $govt_id_image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/ids/';
        
        // Basic validation
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($govt_id_image['type'], $allowedTypes)) {
            $errors[] = 'Invalid file type for ID. Only JPG, PNG, and PDF are allowed.';
        }

        if ($govt_id_image['size'] > 5 * 1024 * 1024) { // 5 MB limit
            $errors[] = 'ID image file is too large. Maximum size is 5MB.';
        }

        if (empty($errors)) {
            $fileExtension = pathinfo($govt_id_image['name'], PATHINFO_EXTENSION);
            $newFilename = uniqid('id_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($govt_id_image['tmp_name'], $destination)) {
                $id_image_path = 'uploads/ids/' . $newFilename; // Store relative path
            } else {
                $errors[] = 'Failed to move uploaded ID file.';
            }
        }
    }

    // --- If there are any errors so far, return them ---
    if (!empty($errors)) {
        return $errors;
    }

    // --- 5. Hash password ---
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // --- 6. Insert user into the database ---
    try {
        $sql = "INSERT INTO people (
                    first_name, 
                    last_name, 
                    email, 
                    password, 
                    dob, 
                    address_1, 
                    city, 
                    state, 
                    zip_5,
                    id_image_path
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            $firstName,
            $lastName,
            $email,
            $passwordHash,
            empty($dob) ? null : $dob,
            $address1,
            $city,
            $state,
            $zip5,
            $id_image_path
        ]);

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $errors[] = 'A database error occurred during registration. Please try again later.';
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
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user_id'] = $user['id'];
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    return []; // Success
}
