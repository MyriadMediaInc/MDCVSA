<?php

namespace App;

use App\Database;

class Person
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM persons");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM persons WHERE id = :id");
        $stmt->bindParam(\':id\', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
