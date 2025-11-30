<?php
/*
 * EditKeyword Class
 * Handles editing an existing keyword in the database.
 */
class editkeyword {
    // Properties
    public $keyword;   // The ID of the keyword to edit
    public $keywordId; // The new keyword value
    public $err = [];  // Array to store error messages
    public $log = [];  // Array to store log messages

    /**
     * Constructor
     * @param int|string $id    The ID of the keyword to edit
     * @param string     $value The new keyword value
     */
    public function __construct($id, $value)
    {
        // Trim whitespace from new value and convert to lowercase
        $trimmed = trim($value);
        $this->keywordId = strtolower($trimmed);

        // Store the original keyword ID
        $this->keyword = $id;
    }

    /**
     * Edit the keyword in the database
     * - Checks if the new keyword already exists
     * - Updates the keyword if it does not exist
     */
    function editKeyword() {
        require __DIR__ . '/../../config/dbOOP.php'; // Include database connection

        $id = $this->keyword;      // Existing keyword ID
        $keyword = $this->keywordId; // New keyword value

        // Check if the new keyword already exists in the database
        $stmt = $conn->prepare('SELECT * FROM keyWords WHERE keyword = ?');
        $stmt->bind_param('s', $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows !== 0) {
            // Keyword already exists → add an error
            $this->err['DB-01'] = 'Keyword already exists with Keyid: ' . $row['keywordId'];
        } else {
            // Keyword does not exist → update the keyword
            $stmt = $conn->prepare('UPDATE keyWords SET keyword = ? WHERE keywordId = ?');
            $stmt->bind_param('si', $keyword, $id);

            if ($stmt->execute()) {
                // Successful update → log it
                $this->log[] = 'DB: updated correctly';
            } else {
                // Update failed → store error
                $this->err['DB-02'] = 'Error during update of keyword: ' . $stmt->error;
            }
        }
    }

    /**
     * Return errors
     * @return array|string Array of error messages or "No errors" if none
     */
    function error() {
        if (!empty($this->err)) {
            return $this->err;
        }
        return "No errors";
    }
}
