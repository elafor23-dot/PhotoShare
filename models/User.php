<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );

        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(
        $firstName,
        $lastName,
        $email,
        $password
    ) {
        $stmt = $this->db->prepare(
            'INSERT INTO users (first_name, last_name, email, password)
             VALUES (:first_name, :last_name, :email, :password)'
        );

        return $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
