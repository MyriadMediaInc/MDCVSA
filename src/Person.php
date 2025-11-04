<?php

class Person
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    /**
     * Find a person by their email address.
     * 
     * @param string $email The email address to search for.
     * @return array|false The person data as an associative array, or false if not found.
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM persons WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * In the future, we can add other person-related methods here, like:
     * - findById(id)
     * - create(data)
     * - update(id, data)
     * - etc.
     */
}
