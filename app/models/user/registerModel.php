<?php

class NewUser
{
    // Active mysqli connection used for all database operations
    private mysqli $conn;

    /**
     * __construct()
     * --------------
     * The model is given an existing mysqli connection from the controller.
     * This ensures:
     *  - The model does not create or manage its own connection
     *  - Database setup logic remains centralized (config/db.php)
     *  - All models share the same connection within a request
     */
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * createUser()
     * ------------
     * Inserts a new user record into the chatUser table.
     * 
     * Expectations:
     *  - All fields in `$data` are already validated, sanitized,
     *    and the password is already securely hashed.
     *  - The controller handles any form validation and error messages.
     *
     * Flow:
     *  1. Prepare a parameterized SQL INSERT statement
     *  2. Bind user values safely to prevent SQL injection
     *  3. Execute the statement
     *  4. Return true if insert succeeded, false otherwise
     */
    public function createUser(array $data): bool
    {
        // SQL uses placeholders (?) for safe prepared-statement insertion
        $sql = "INSERT INTO chatUser (firstName, lastName, username, mail, userpassword, role)
                VALUES (?, ?, ?, ?, ?, 'standard')";

        // Prepare statement — returns false if SQL is invalid or DB error occurs
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // Could optionally log $this->conn->error here
            return false;
        }

        /**
         * bind_param() assigns each ? to a variable.
         * 'sssss' means:
         *  s = string
         *  s = string
         *  s = string
         *  s = string
         *  s = string
         * 
         * All user input is passed as parameterized values,
         * eliminating SQL injection risk entirely.
         */
        $stmt->bind_param(
            'sssss',
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['mail'],
            $data['password'] // hashed password from controller
        );

        // Execute the INSERT query — returns true/false based on success
        return $stmt->execute();
    }
}
?>