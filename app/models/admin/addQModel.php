<?php
/* 
 * Add Question Model
 * Handles adding a question to the database along with its associated keywords.
 */
class addQModel {
    
    // Logs to store messages during question/keyword insertion
    public $addQLog = [];

    // Question fields
    public $questionDescription; // Text description of the question
    public $questionAnswer;      // Text answer of the question

    // Keyword management
    public $keywordArr = [];     // Array containing all keywords
    public $keywordIds = [];     // Array containing corresponding keyword IDs in the database
    public $keyword1;
    public $keyword2;
    public $keyword3;
    public $keyword4;
    public $keyword5;
    public $keyword6;
    public $keyword7;
    public $keyword8;
    public $keyword9;
    public $keyword10;

    // Optional category (not currently used in the code)
    public $category;

    /**
     * Constructor
     * Initializes the object from POST data array.
     * Converts values to lowercase and trims whitespace.
     * Creates keyword array and checks/creates keywords in the database.
     */
    public function __construct($postArr)
    {
        // Loop through class properties and set them from POST data if available
        foreach ($this as $prop => $value) {
            if (isset($postArr[$prop])) {
                $this->$prop = strtolower(trim($postArr[$prop] ?? ''));
            }
        }

        // Combine individual keyword properties into an array
        $this->keywordArr = [
            $this->keyword1, $this->keyword2, $this->keyword3, $this->keyword4, $this->keyword5,
            $this->keyword6, $this->keyword7, $this->keyword8, $this->keyword9, $this->keyword10
        ];

        // Check if keywords exist in the database, add if missing
        $this->checkKeywordExist();

        // Debug output for logs and keywords
        print_r($this->addQLog);
        print_r($this->keywordArr);
    }

    /**
     * Check each keyword in the database.
     * If it does not exist, add it.
     * Stores keyword IDs for later question insertion.
     */
    public function checkKeywordExist(){
        require __DIR__ . '/../../config/dbOOP.php'; // Include database connection

        // Prepare statement to check for existing keyword
        $stmt = $conn->prepare('SELECT * FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);

        foreach($this->keywordArr as $key){
            if($key !== ""){
                $bind = $key;
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0){
                    // Keyword not found → insert into keywords table
                    $add = $conn->prepare('INSERT INTO keywords (keyword) VALUES (?)');
                    $add->bind_param('s', $key);
                    $add->execute();

                    $keyId = intval($this->getkeywordId($key)); // Retrieve inserted ID
                    $this->addQLog[] = '"' . $key . '" added to keywords table';

                } else {
                    // Keyword exists
                    $this->addQLog[] = '"' . $key . '" already exists in keywords table';
                    $row = $result->fetch_assoc();
                    $keyId = intval($row['keywordId']);
                }

                // Store keyword ID for question insertion
                $this->keywordIds[] = $keyId;
            }
            else{
                // Empty keyword → store null
                $this->keywordIds[] = null;
            }
        }
    }

    /**
     * Retrieve the ID of a keyword from the database
     * @param string $bind Keyword to lookup
     * @return int Keyword ID
     */
    private function getkeywordId($bind){
        require __DIR__ . '/../../config/dbOOP.php';
        $stmt = $conn->prepare('SELECT keywordId FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['keywordId'];
    }

    /**
     * Add the question to the database
     * Inserts questionDescription, questionAnswer, and the 10 keyword IDs.
     */
    public function addQuestion(){
        require __DIR__ . '/../../config/dbOOP.php';

        $stmt = $conn->prepare("INSERT INTO questions 
            (questionDescription, questionAnswer, keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7, keyword8, keyword9, keyword10)
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters: question text + 10 keyword IDs
        $stmt->bind_param(
            'ssiiiiiiiiii', 
            $this->questionDescription, 
            $this->questionAnswer, 
            $this->keywordIds[0], 
            $this->keywordIds[1], 
            $this->keywordIds[2], 
            $this->keywordIds[3], 
            $this->keywordIds[4], 
            $this->keywordIds[5], 
            $this->keywordIds[6], 
            $this->keywordIds[7], 
            $this->keywordIds[8], 
            $this->keywordIds[9], 
        );

        // Execute insertion and log result
        if($stmt->execute()){
            $this->addQLog[] = 'Inserted correctly';
        } else {
            $this->addQLog['DB-03'] = 'Error inserting Question: ' . $stmt->error;
        }
    }
}
