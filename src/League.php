<?php

namespace App;

use PDO;

class League
{
    private $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Fetches all leagues from the database.
     *
     * @return array
     */
    public function getAllLeagues(): array
    {
        $stmt = $this->conn->prepare("SELECT league_name FROM leagues ORDER BY league_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
