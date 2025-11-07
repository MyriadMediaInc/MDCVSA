<?php

namespace App\Models;

use PDO;

class Person {
    private $conn;
    private $table_name = "persons";

    public function __construct() {
        // The Database class is now loaded via bootstrap.php
        // We can get the connection from the static method.
        $this->conn = \Database::getInstance()->getConnection();
    }

    public function getAll() {
        $query = "SELECT id, name, email, phone, created_at, updated_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Future methods for CRUD operations (create, read, update, delete)
    // would be added here.

}
