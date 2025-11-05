<?php

function get_all_leagues(PDO $db): array {
    $stmt = $db->query("SELECT * FROM leagues ORDER BY league_name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_league_by_id(PDO $db, int $id): ?array {
    $stmt = $db->prepare("SELECT * FROM leagues WHERE id = ?");
    $stmt->execute([$id]);
    $league = $stmt->fetch(PDO::FETCH_ASSOC);
    return $league ?: null;
}

// FIX: Using correct column names `date_formed` and `date_disbanded`
function add_league(PDO $db, string $league_name, ?string $date_formed, ?string $date_disbanded): bool {
    $sql = "INSERT INTO leagues (league_name, date_formed, date_disbanded) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    // The execute method returns true on success and false on failure.
    return $stmt->execute([$league_name, $date_formed, $date_disbanded]);
}

// FIX: Using correct column names `date_formed` and `date_disbanded`
function update_league(PDO $db, int $id, string $league_name, ?string $date_formed, ?string $date_disbanded): bool {
    $sql = "UPDATE leagues SET league_name = ?, date_formed = ?, date_disbanded = ? WHERE league_id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$league_name, $date_formed, $date_disbanded, $id]);
}

function delete_league(PDO $db, int $id): bool {
    try {
        $stmt = $db->prepare("DELETE FROM leagues WHERE league_id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error deleting league: " . $e->getMessage());
        return false;
    }
}
