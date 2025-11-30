<?php
/*
 * quickQ Class
 * Retrieves a single question and its answer based on a provided question ID.
 * Typically used for "quick access" features where the user selects a specific question.
 */
class quickQ {
    public $value;  // The ID of the selected question
    public $info = []; // Stores the fetched question data: [questionId => [description, answer]]

    /**
     * Constructor
     * @param array $post $_POST array or similar containing 'quickQuestion'
     */
    public function __construct($post)
    {
        // Store the provided question ID
        $this->value = $post['quickQuestion'];

        // Fetch the question information from the database
        $this->getQInfo();
    }

    /**
     * Fetch question details from the database
     * Populates the $info property with the question description and answer
     */
    private function getQInfo() {
        // Include database connection
        require __DIR__ . '/../../config/dbOOP.php';

        // Select the correct database
        $conn->select_db('FAQUiaChatbot');

        // Prepare statement to fetch the question by ID
        $stmt = $conn->prepare('SELECT * FROM questions WHERE questionId = ?');
        $stmt->bind_param('i', $this->value); // Bind the question ID
        $stmt->execute();

        // Get the result and fetch the row
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Store question description and answer in info array
        // Keyed by questionId for easy reference
        $this->info[$row['questionId']] = [
            $row['questionDescription'],
            $row['questionAnswer']
        ];
    }
}
?>
