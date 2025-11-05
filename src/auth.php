<?php

// src/auth.php

/**
 * Registers a new user with all their details.
 * This function is the updated version that handles all fields from the new registration form.
 *
 * @return int|array Returns the new user's ID on success, or an array of errors on failure.
 */
function register_user(
    PDO $db,
    string $firstName,
    string $lastName,
    string $email,
    string $password,
    string $passwordConfirm,
    string $terms,
    string $dob,
    string $address1,
    ?string $address2,
    string $city,
    string $state,
    string $zip5,
    ?string $zip4,
    ?string $phone,
    ?array $govtIdImage
): int|array {
    $errors = [];

    // --- Server-side Validation ---
    if (empty($firstName)) { $errors[] = 'First name is required.'; }
    if (empty($lastName)) { $errors[] = 'Last name is required.'; }
    if (empty($email)) { $errors[] = 'Email is required.'; }
    if (empty($password)) { $errors[] = 'Password is required.'; }
    if (empty($dob)) { $errors[] = 'Date of birth is required.'; }
    if (empty($address1)) { $errors[] = 'Address is required.'; }
    if (empty($city)) { $errors[] = 'City is required.'; }
    if (empty($state)) { $errors[] = 'State is required.'; }
    if (empty($zip5)) { $errors[] = 'Zip code is required.'; }

    if ($password !== $passwordConfirm) {
        $errors[] = 'Passwords do not match.';
    }
    if (empty($terms)) {
        $errors[] = 'You must agree to the terms and conditions.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Check if email already exists
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM people WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'An account with this email address already exists.';
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error for debugging
        $errors[] = 'Database error checking for existing email.';
    }

    // --- Image Upload Handling ---
    $idImagePath = null;
    if (isset($govtIdImage) && $govtIdImage['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../public/uploads/ids/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $errors[] = 'Failed to create upload directory.';
            }
        }

        if (empty($errors)) {
            $filename = uniqid('id_', true) . '_' . preg_replace('/[^a-zA-Z0-9._-]', '_', basename($govtIdImage['name']));
            $destination = $uploadDir . $filename;

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            if (in_array($govtIdImage['type'], $allowedTypes)) {
                 if (move_uploaded_file($govtIdImage['tmp_name'], $destination)) {
                    $idImagePath = 'uploads/ids/' . $filename; // Relative path from public root
                } else {
                    $errors[] = 'Failed to move uploaded file.';
                }
            } else {
                $errors[] = 'Invalid file type for ID scan. Please upload an image or PDF.';
            }
        }
    } elseif (isset($govtIdImage) && $govtIdImage['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'There was an error with the file upload.';
    }

    // If there are any validation errors, return them immediately
    if (!empty($errors)) {
        return $errors;
    }

    // --- Database Insertion ---
    try {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO people (
                    first_name, last_name, email, password, dob, 
                    address_1, address_2, city, state, zip_5, zip_4, 
                    phone, identity_verified_indicator, id_image_path, status
                ) VALUES (
                    :first_name, :last_name, :email, :password, :dob,
                    :address_1, :address_2, :city, :state, :zip_5, :zip_4,
                    :phone, :identity_verified, :id_image_path, 'active'
                )";
        
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':dob', $dob);
        $stmt->bindValue(':address_1', $address1);
        $stmt->bindValue(':address_2', $address2, PDO::PARAM_STR);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':state', $state);
        $stmt->bindValue(':zip_5', $zip5);
        $stmt->bindValue(':zip_4', $zip4, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':identity_verified', $idImagePath ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':id_image_path', $idImagePath, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int)$db->lastInsertId();
        } else {
            return ['Database error: Could not register user.'];
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error for debugging
        return ['A database error occurred during registration.'];
    }
}


/*
 * The functions below are unchanged.
 */

function login_user(PDO $db, string $email, string $password): array {
    try {
        $stmt = $db->prepare("SELECT id, password FROM people WHERE email = ? AND deleted_at IS NULL AND status = 'active'");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            return []; // Success
        }

        return ['Invalid email or password, or account is inactive.'];
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error for debugging
        return ['Database error during login.'];
    }
}

function get_user_by_id(PDO $db, int $id): ?array {
     try {
        $stmt = $db->prepare("SELECT * FROM people WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error for debugging
        return null;
    }
}

function logout_user() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION = [];
    
    // If using cookies for session, invalidate the cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

?>