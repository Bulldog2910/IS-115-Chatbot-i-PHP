<?php
// app/models/User.php

class User
{
    private mysqli $conn; // Database connection instance

    public function __construct(mysqli $conn)
    {
        // Store the injected DB connection
        $this->conn = $conn;

        // Ensure the correct database is selected before running queries
        $this->conn->select_db('FAQUiaChatbot');
    }

    /**
     * Finds a single user row by email.
     *
     * @param string $email The user's email to search for.
     * @return array|null Returns the user row as an associative array, or null if no user was found.
     */
    public function findByEmail(string $email): ?array
    {
        // Prepared statement to safely query the user table
        $sql = 'SELECT * FROM chatUser WHERE mail = ?';
        
        // Prepare the SQL query to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        // Bind the email parameter to the query
        $stmt->bind_param('s', $email);

        // Execute the query
        $stmt->execute();

        // Get the result set from the executed statement
        $result = $stmt->get_result();

        // If no row was returned, the user does not exist
        if ($result->num_rows === 0) {
            return null;
        }

        // Return the user row as an associative array
        return $result->fetch_assoc();
    }
}
?>