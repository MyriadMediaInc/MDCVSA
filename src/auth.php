<?php

function register_user(PDO $db, string $email, string $password, string $firstName, string $lastName): array {
    $errors = [];

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
    $stmt = $db->prepare("SELECT id, password, password_hash FROM people WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return ['Invalid email or password.'];
    }

    // Safely determine which hash to use.
    $hash = null;
    if (!empty($user['password_hash'])) {
        $hash = $user['password_hash'];
    } elseif (!empty($user['password'])) {
        $hash = $user['password'];
    }

    // If a hash was found and the password verifies, log the user in.
    if ($hash !== null && password_verify($password, $hash)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        return []; // Success
    }

    // Otherwise, the login fails.
    return ['Invalid email or password.'];
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