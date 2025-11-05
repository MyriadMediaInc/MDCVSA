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

    if ($user && password_verify($password, $user['password_hash'])) {
        // On successful password verification, start the session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);

        // Store user ID in session
        $_SESSION['user_id'] = $user['id'];

        // Return an empty errors array to signify success
        return []; 
    } else {
        // If user not found or password incorrect
        $errors[] = 'Invalid email or password.';
    }

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
    
    // Unset all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
}

?>
