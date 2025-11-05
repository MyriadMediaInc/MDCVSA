<?php

function register_user(PDO $db, string $email, string $password, string $firstName, string $lastName): array {
    $errors = [];

    // Check if email already exists
    $stmt = $db->prepare("SELECT COUNT(*) FROM people WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'Email already in use.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO people (first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    }

    return $errors;
}

function login_user(PDO $db, string $email, string $password): array {
    $errors = [];

    $stmt = $db->prepare("SELECT * FROM people WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists AND if the password_hash is set and not null
    if ($user && isset($user['password_hash']) && $user['password_hash'] !== null) {
        // Now we can safely verify the password
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, proceed with login.
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];

            return []; // Return empty array to signify success
        }
    }

    // If user not found, password incorrect, or hash is missing, return a generic error.
    $errors[] = 'Invalid email or password.';
    return $errors;
}

function get_user_by_id(PDO $db, int $id): ?array {
    $stmt = $db->prepare("SELECT * FROM people WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
}

function logout_user() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION = [];
    
    session_destroy();
}

?>