<?php
/*
 * chatbotModel Class
 * Handles the main keyword-based matching logic for the FAQ chatbot.
 * 
 * Workflow:
 * 1. Takes input words (lemmas) from user question.
 * 2. Finds matching keywords in database (including synonyms via Datamuse API).
 * 3. Fetches questions linked to these keywords.
 */
class chatbotModel {
    public $keywordArr;   // Array of keyword IDs matched from user input
    public $QArr;         // Array of questions matched to these keywords
    public $chatbotLog;   // Logs for debugging keyword matches
    public $wordArr;      // Optional array of input words (not used here)

    /**
     * Constructor
     * @param array $lemmaArr Array of words from user input
     */
    function __construct($lemmaArr)
    {
        // Extract matching keyword IDs from the user input
        $this->keywordArr = $this->getKeywordArr($lemmaArr);

        if($this->keywordArr == []) {
            // No keywords found → show message
            $this->QArr = [];
        } else {
            // Fetch all matching questions based on found keywords
            $this->QArr = $this->getQArr();
        }
    }

    /**
     * Fetch questions associated with matched keywords
     * @return array $Arr Associative array: questionId => [description, answer]
     */
    public function getQArr()
    {
        include __DIR__ . '/../../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        // Prepare statement to match any of the 10 keyword columns
        $stmt = $conn->prepare(
            'SELECT * FROM questions 
             WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ? OR keyword4 = ? 
             OR keyword5 = ? OR keyword6 = ? OR keyword7 = ? OR keyword8 = ? 
             OR keyword9 = ? OR keyword10 = ?'
        );

        $Arr = [];

        // Loop through all matched keyword IDs
        foreach($this->keywordArr as $key) {
            $stmt->bind_param('iiiiiiiiii', $key, $key, $key, $key, $key, $key, $key, $key, $key, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            // Store each matched question
            while($row = $result->fetch_assoc()) {
                $Arr[$row['questionId']] = [
                    $row['questionDescription'],
                    $row['questionAnswer']
                ];
            }
        }

        return $Arr;
    }

    /**
     * Debug function to print matched questions
     */
    public function printQ() {
        foreach($this->QArr as $id => $q) {
            echo $id . ": " . $q;
        }
    }

    /**
     * Extract matching keyword IDs for a given array of words
     * @param array $lemmaArr Words from user input
     * @return array $keywordArr Matched keyword IDs
     */
    private function getKeywordArr($lemmaArr)
    {
        $keywordArr = [];

        // Connect to DB
        include __DIR__ . '/../../config/dbOOP.php';

        // Prepared statement to check candidate word against keywords table
        $stmt = $conn->prepare('SELECT keywordId FROM keyWords WHERE LOWER(keyword) = ?');
        if (!$stmt) return [];

        foreach ($lemmaArr as $word) {
            $word = trim($word);
            if ($word === '') continue;

            // Candidate words to check
            $candidates = [$word];

            // Get synonyms via Datamuse API
            $synonyms = $this->getSynonymsFromDatamuse($word);
            foreach ($synonyms as $syn) {
                $syn = trim($syn);
                if ($syn !== '' && strpos($syn, ' ') === false) {
                    $candidates[] = $syn;
                }
            }

            // Check each candidate against the keywords table
            foreach ($candidates as $candidate) {
                $possibleKey = strtolower($candidate);
                $stmt->bind_param('s', $possibleKey);
                $stmt->execute();
                $stmt->bind_result($keywordId);

                while ($stmt->fetch()) {
                    $this->chatbotLog[] = "MATCH: '{$possibleKey}' => keywordId {$keywordId}<br>";
                    if(!is_null($keywordId)){
                        $keywordArr[$keywordId] = $keywordId; // store unique IDs
                    }
                }
            }
        }

        $stmt->close();
        $conn->close();

        if (!empty($keywordArr)) return $keywordArr;

        $this->chatbotLog[] = "There is no keyword in the question";
        return [];
    }

    /**
     * Fetch synonyms from Datamuse API
     * @param string $word Word to find synonyms for
     * @return array List of synonyms
     */
    public function getSynonymsFromDatamuse(string $word): array
    {
        $url = 'https://api.datamuse.com/words?rel_syn=' . urlencode($word);
        $json = @file_get_contents($url);
        if ($json === false) return [];

        $data = json_decode($json, true);
        if (!is_array($data)) return [];

        $result = [];
        foreach ($data as $item) {
            if (isset($item['word'])) $result[] = $item['word'];
        }

        return $result;
    }
}
?>
