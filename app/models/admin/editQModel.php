<?php
/**
 *    model:
 *  - Holds question data and keyword data
 *  - Reads/writes to the database
 *  - Blind to controller/view (no redirects, no echo)
 */
class editQModel {

    /** @var mysqli */
    private mysqli $conn;       // DB connection injected by the controller

    // Logs to store messages during question/keyword update
    public array $addQLog = [];

    // Question fields
    public ?string $questionDescription = null; // The question text
    public ?string $questionAnswer      = null; // The answer text

    // Keyword management
    public array $keywordArr = [];  // Array containing all keyword values
    public array $keywordIds = [];  // Array containing corresponding keyword IDs in the database

    public ?string $keyword1  = null;
    public ?string $keyword2  = null;
    public ?string $keyword3  = null;
    public ?string $keyword4  = null;
    public ?string $keyword5  = null;
    public ?string $keyword6  = null;
    public ?string $keyword7  = null;
    public ?string $keyword8  = null;
    public ?string $keyword9  = null;
    public ?string $keyword10 = null;

    // Question ID
    public ?int $Qid = null;

    /**
     * Constructor
     * -----------
     * @param mysqli $conn    Active DB connection (from config/dbOOP.php)
     * @param array  $postArr Raw POST data from controller
     *
     * Initializes object properties from POST array.
     * Normalizes keywords to lowercase and trims whitespace.
     * Builds the keyword array and checks/creates keywords in the DB.
     */
    public function __construct(mysqli $conn, array $postArr)
    {
        $this->conn = $conn;

        foreach ($this as $prop => $value) {

            // Skip array properties (like $keywordArr and $keywordIds)
            if (is_array($value)) {
                continue;
            }

            // Skip the DB connection itself
            if ($prop === 'conn') {
                continue;
            }

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

        // Ensure Qid is set from identificatorId (same logic as before)
        if (isset($postArr['identificatorId'])) {
            $this->Qid = intval($postArr['identificatorId']);
        }

        // Build keyword array (same order/logic as before)
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
    public function checkKeywordExist(): void
    {
        $bind = null;

        // Prepare select statement
        $stmt = $this->conn->prepare('SELECT * FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);

        foreach ($this->keywordArr as $key) {
            if ($key !== "" && $key !== null) {
                $bind = $key;
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    // Keyword does not exist → insert it
                    $add = $this->conn->prepare('INSERT INTO keywords (keyword) VALUES (?)');
                    $add->bind_param('s', $key);
                    $add->execute();

                    $keyId = intval($this->getKeywordId($key));
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
    private function getKeywordId(string $bind): int
    {
        $stmt = $this->conn->prepare('SELECT keywordId FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return (int)$row['keywordId'];
    }

    /**
     * Update the question in the database
     * Updates question text, answer, and the 10 associated keywords
     */
    public function updateQ(): void
    {
        $stmt = $this->conn->prepare(
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

        if ($stmt->execute()) {
            $this->addQLog[] = 'Updated correctly';
        } else {
            $this->addQLog[] = ['DB-03' => 'Error updating Question: ' . $stmt->error];
        }
    }
}
?>