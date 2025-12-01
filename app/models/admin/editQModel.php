<?php
/*
 * EditQModel Class
 * Handles editing an existing question and its associated keywords in the database.
 */
class editQModel {
    
    // Logs to store messages during question/keyword update
    public $addQLog = [];

    // Question fields
    public $questionDescription; // The question text
    public $questionAnswer;      // The answer text

    // Keyword management
    public $keywordArr = [];     // Array containing all keyword values
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

    // Question ID
    public $Qid;

    /**
     * Constructor
     * Initializes object properties from POST array
     * Normalizes keywords to lowercase and trims whitespace
     * Builds the keyword array and checks/creates keywords in the DB
     */
    public function __construct($postArr)
    {
        foreach ($this as $prop => $value) {

            // Skip array properties (like $keywordArr and $keywordIds)
            if (is_array($value)) continue;

            if (isset($postArr[$prop])) {

                // IDs and main text fields should not be lowercased
                if ($prop === "Qid" || $prop === "questionDescription" || $prop === "questionAnswer") {
                    $this->$prop = trim($postArr[$prop]);
                } else {
                    // Keywords normalized to lowercase
                    $this->$prop = strtolower(trim($postArr[$prop]));
                }
            }
        }

        // Ensure Qid is set from identificatorId
        $this->Qid = intval($postArr['identificatorId']);

        // Build keyword array
        $this->keywordArr = [
            $this->keyword1, $this->keyword2, $this->keyword3, $this->keyword4, $this->keyword5,
            $this->keyword6, $this->keyword7, $this->keyword8, $this->keyword9, $this->keyword10
        ];

        // Check if keywords exist in DB and create missing ones
        $this->checkKeywordExist();
    }

    /**
     * Check if each keyword exists in the database
     * - If not, inserts the keyword
     * - Stores corresponding keyword IDs
     */
    public function checkKeywordExist(){
        require __DIR__ . '/../../config/dbOOP.php';
        $bind = null;

        // Prepare select statement
        $stmt = $conn->prepare('SELECT * FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);

        foreach($this->keywordArr as $key){
            if($key !== ""){
                $bind = $key;
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0){
                    // Keyword does not exist → insert it
                    $add = $conn->prepare('INSERT INTO keywords (keyword) VALUES (?)');
                    $add->bind_param('s', $key);
                    $add->execute();

                    $keyId = intval($this->getkeywordId($key));
                    $this->addQLog[] = '"' . $key . '" added to keywords table';
                } else {
                    // Keyword already exists → fetch its ID
                    $this->addQLog[] = '"' . $key . '" already exists in keywords table';
                    $row = $result->fetch_assoc();
                    $keyId = intval($row['keywordId']);
                }

                $this->keywordIds[] = $keyId;
            } else {
                // Empty keyword → store null
                $this->keywordIds[] = null;
            }
        }
    }

    /**
     * Retrieve the ID of a keyword
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
     * Update the question in the database
     * Updates question text, answer, and the 10 associated keywords
     */
    public function updateQ(){
        require __DIR__ . '/../../config/dbOOP.php';

        // Prepare update statement for the questions table
        $stmt = $conn->prepare(
            "UPDATE questions SET
                questionDescription = ?,
                questionAnswer = ?,
                keyword1 = ?,
                keyword2 = ?,
                keyword3 = ?,
                keyword4 = ?,
                keyword5 = ?,
                keyword6 = ?,
                keyword7 = ?,
                keyword8 = ?,
                keyword9 = ?,
                keyword10 = ?
            WHERE questionId = ?"
        );

        // Bind question data and keyword IDs
        $stmt->bind_param(
            'ssiiiiiiiiiii', 
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
            $this->Qid
        );

        // Execute update and log result
        if($stmt->execute()){
            $this->addQLog[] = 'Updated correctly';
        } else {
            $this->addQLog[] = ['DB-03' => 'Error updating Question: ' . $stmt->error];
        }
    }
}
?>
