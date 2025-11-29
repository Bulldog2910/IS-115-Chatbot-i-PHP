<?php

class User
{
    private mysqli $conn; 
    /**
     * Database connection instance injected from outside.
     * Ensures this class does not create its own connection,
     * keeping it reusable and testable.
     */

    public function __construct(mysqli $conn)
    {
        // Store injected mysqli object for all DB operations
        $this->conn = $conn;

        // Select target database to guarantee queries run in the correct schema
        $this->conn->select_db('FAQUiaChatbot');
    }

    /**
     * Fetch a single user based on email.
     * Uses a prepared statement to prevent SQL injection.
     *
     * @param string $email Email to look up
     * @return array|null Associative array of the user row, or null if missing
     */
    public function findByEmail(string $email): ?array
    {
        // Define SQL with placeholder (?) for safe parameter binding
        $sql = 'SELECT * FROM chatUser WHERE mail = ?';
        
        // Prepare query — mysqli handles parsing and escaping internally
        $stmt = $this->conn->prepare($sql);

        // Bind email to placeholder — type "s" means string
        $stmt->bind_param('s', $email);

        // Run the query on the database
        $stmt->execute();

        // Retrieve result set containing matching rows (0 or 1)
        $result = $stmt->get_result();

        // No matching user found → return null
        if ($result->num_rows === 0) {
            return null;
        }

        // Convert DB row into associative array: ['mail' => '...', ...]
        $row = $result->fetch_assoc();

        return $row;
    }

    /**
     * Insert a new user into the database.
     * Expects $data to contain firstName, lastName, username, mail, password.
     * Password MUST be pre-hashed in the controller before calling this method.
     *
     * @param array $data Array of user fields
     * @return bool True on success, false on DB/SQL failure
     */
    public function createUser(array $data): bool
    {
        /**
         * SQL INSERT with five parameter placeholders:
         * The 'role' column is hardcoded to "standard" for security —
         * users cannot assign themselves admin rights during registration.
         */
        $sql = "INSERT INTO chatUser (firstName, lastName, username, mail, userpassword, role)
                VALUES (?, ?, ?, ?, ?, 'standard')";

        // Prepare the SQL — returns false if syntax error or DB issue
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // Optionally log $this->conn->error for debugging
            return false;
        }

        /**
         * Bind values to the placeholders:
         * 'sssss' → 5 strings
         * Ensures MySQL treats input strictly as data, not executable SQL.
         */
        $stmt->bind_param(
            'sssss',
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['mail'],
            $data['password'] // hashed password — never store raw passwords
        );

        // Execute the insert statement — returns true on success
        return $stmt->execute();
    }

    /**
     * Check whether a user with the given email exists.
     * Efficient approach by selecting only the constant '1' instead of full row.
     *
     * @param string $email
     * @return bool True if email exists, false otherwise
     */
    public function existsByEmail(string $email): bool
    {
        // Lightweight existence check
        $sql  = 'SELECT 1 FROM chatUser WHERE mail = ? LIMIT 1';

        // Prepare query — fail-safe return false on errors
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        // Bind email and execute
        $stmt->bind_param('s', $email);
        $stmt->execute();

        /**
         * store_result() loads the result into memory,
         * allowing access to num_rows without fetching the row itself.
         */
        $stmt->store_result();

        // If one row exists → email already registered
        return $stmt->num_rows > 0;
    }
}
?>
