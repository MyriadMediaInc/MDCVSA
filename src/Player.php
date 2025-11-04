<?php

namespace App;

use PDO;
use PDOException;

class Player
{
    private $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Registers a player for a league.
     *
     * @param array $data The player's registration data.
     * @return int The ID of the new registration record.
     * @throws \Exception
     */
    public function register(array $data): int
    {
        $this->conn->beginTransaction();

        try {
            // 1. Find or create the person
            $stmt = $this->conn->prepare("SELECT person_id FROM persons WHERE email = :email");
            $stmt->execute(['email' => $data['email']]);
            $person_id = $stmt->fetchColumn();

            if (!$person_id) {
                $sql = "INSERT INTO persons (first_name, last_name, email, dob, street_address_1, street_address_2, street_address_3, city, state_code, zip5, zip4, cell_phone) VALUES (:first_name, :last_name, :email, :dob, :street_address_1, :street_address_2, :street_address_3, :city, :state_code, :zip5, :zip4, :cell_phone)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':first_name' => $data['first_name'],
                    ':last_name' => $data['last_name'],
                    ':email' => $data['email'],
                    ':dob' => $data['dob'],
                    ':street_address_1' => $data['street_address_1'],
                    ':street_address_2' => $data['street_address_2'] ?? null,
                    ':street_address_3' => $data['street_address_3'] ?? null,
                    ':city' => $data['city'],
                    ':state_code' => $data['state_code'],
                    ':zip5' => $data['zip5'],
                    ':zip4' => $data['zip4'] ?? null,
                    ':cell_phone' => $data['cell_phone'] ?? null
                ]);
                $person_id = $this->conn->lastInsertId();
            }

            // 2. Find the league ID
            $stmt = $this->conn->prepare("SELECT league_id FROM leagues WHERE league_name = :league_name");
            $stmt->execute(['league_name' => $data['league_name']]);
            $league_id = $stmt->fetchColumn();

            if (!$league_id) {
                throw new \Exception("League '{$data['league_name']}' not found.");
            }

            // 3. Create the player registration
            $stmt = $this->conn->prepare("INSERT INTO player_registrations (person_id, league_id) VALUES (:person_id, :league_id)");
            $stmt->execute([
                ':person_id' => $person_id,
                ':league_id' => $league_id
            ]);
            $registration_id = $this->conn->lastInsertId();

            $this->conn->commit();

            return (int)$registration_id;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new \Exception("Registration failed: " . $e->getMessage());
        }
    }
}
