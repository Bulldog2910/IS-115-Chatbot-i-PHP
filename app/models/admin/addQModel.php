<?php
/* 
 * Add Question Model
 * Handles adding a question to the database along with its associated keywords.
 */
class addQModel {
    private $conn;
    
    // Logs to store messages during question/keyword insertion
    public $addQLog = [];
    // Keyword management
    public $keywordIds = [];     // Array containing corresponding keyword IDs in the database

    // Optional category (not currently used in the code)
    public $category;

    public $keywordArr = [];
    public $questionDescription;
    public $questionAnswer;

    /**
     * Constructor
     * Initializes the object from POST data array.
     * Converts values to lowercase and trims whitespace.
     * Creates keyword array and checks/creates keywords in the database.
     */
    public function __construct($keywordArr, $conn, $QDescription, $ADescription)
    {
        // Check if keywords exist in the database, add if missing
        $this->conn = $conn;
        $this->keywordArr = $keywordArr;
        $this->questionDescription = $QDescription;
        $this->questionAnswer = $ADescription;
    }

    /**
     * Check each keyword in the database.
     * If it does not exist, add it.
     * Stores keyword IDs for later question insertion.
     */
    public function checkKeywordExist(){
        // Prepare statement to check for existing keyword
        $stmt = $this->conn->prepare('SELECT * FROM keywords WHERE keyword = ?');

        foreach($this->keywordArr as $key){
            if($key !== ""){
                $stmt->bind_param('s', $key);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0){
                    // Keyword not found → insert into keywords table
                    $add = $this->conn->prepare('INSERT INTO keywords (keyword) VALUES (?)');
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
        $stmt = $this->conn->prepare('SELECT keywordId FROM keywords WHERE keyword = ?');
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
        $stmt = $this->conn->prepare("INSERT INTO questions 
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
