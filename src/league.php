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

function add_league(PDO $db, string $league_name, ?string $start_date, ?string $end_date): bool {
    try {
        $stmt = $db->prepare(
            "INSERT INTO leagues (league_name, start_date, end_date) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$league_name, $start_date, $end_date]);
    } catch (PDOException $e) {
        error_log("Error creating league: " . $e->getMessage());
        return false;
    }
}

function update_league(PDO $db, int $id, string $league_name, ?string $start_date, ?string $end_date): bool {
    try {
        $stmt = $db->prepare(
            "UPDATE leagues SET league_name = ?, start_date = ?, end_date = ? WHERE id = ?"
        );
        return $stmt->execute([$league_name, $start_date, $end_date, $id]);
    } catch (PDOException $e) {
        error_log("Error updating league: " . $e->getMessage());
        return false;
    }
}

function delete_league(PDO $db, int $id): bool {
    try {
        $stmt = $db->prepare("DELETE FROM leagues WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error deleting league: " . $e->getMessage());
        return false;
    }
}

?>
