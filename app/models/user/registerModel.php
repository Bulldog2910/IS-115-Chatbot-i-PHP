<?php

class NewUser
{
    private mysqli $conn;

    /**
     * The User model receives a mysqli connection instance.
     * The controller is responsible for constructing and passing it.
     */
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
        $this->conn->select_db('FAQUiaChatbot');
    }

    /**
     * Inserts a new user into the chatUser table.
     * Expects already validated and cleaned data.
     */
    public function createUser(array $data): bool
    {
        $sql = "INSERT INTO chatUser (firstName, lastName, username, mail, userpassword, role)
                VALUES (?, ?, ?, ?, ?, 'standard')";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            'sssss',
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['mail'],
            $data['password'] // already hashed
        );

        return $stmt->execute();
    }
}
