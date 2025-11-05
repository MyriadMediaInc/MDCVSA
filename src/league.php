<?php

function get_all_leagues(PDO $db): array {
    $stmt = $db->query("SELECT * FROM leagues ORDER BY league_name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// FIX: Using correct primary key `league_id` in the WHERE clause
function get_league_by_id(PDO $db, int $id): ?array {
    $stmt = $db->prepare("SELECT * FROM leagues WHERE league_id = ?");
    $stmt->execute([$id]);
    $league = $stmt->fetch(PDO::FETCH_ASSOC);
    return $league ?: null;
}

function add_league(PDO $db, string $league_name, string $date_formed, string $date_disbanded): bool {
    $sql = "INSERT INTO leagues (league_name, date_formed, date_disbanded) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$league_name, $date_formed, $date_disbanded]);
}

function update_league(PDO $db, int $id, string $league_name, string $date_formed, string $date_disbanded): bool {
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
