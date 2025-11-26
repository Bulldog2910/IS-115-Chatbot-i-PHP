<?php 

class chatbotModel{
    private $keywordArr;   // Array of matched keyword IDs extracted from user input
    private $QArr;         // Array of matching question rows from the database


    function __construct($Q)
    {
        /**
         * Constructor receives $Q, expected to be $_POST or an array containing 'question'.
         * Step 1: Extract all keyword IDs from the question text.
         * Step 2: Fetch all stored questions that contain at least one of these keyword IDs.
         */
        $this->keywordArr = $this->getKeywordArr($Q);
        $this->QArr = $this->getQArr();
    }

    public function getQArr()
    {
        /**
         * Fetch all questions associated with the matched keyword IDs.
         * 
         * The table structure: questions(keyword1, keyword2, keyword3, ...)
         * 
         * Logic:
         *  - Prepare a single SQL statement selecting questions where ANY of the keyword columns match.
         *  - Re-bind the parameter for each keyword found in the input.
         *  - Execute the statement repeatedly, once for each keyword.
         */

        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        $stmt = $conn->prepare('
            SELECT questionDescription, questionId 
            FROM questions 
            WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ?
        ');

        // Bind 3 integer parameters. NOTE: the same variable is reused and updated in the loop.
        $stmt->bind_param('iii', $possibleKey, $possibleKey, $possibleKey);

        $Arr = [];
        
        // Loop through all discovered keyword IDs
        foreach($this->keywordArr as $key)
        {
            // Update the parameter before executing
            $possibleKey = $key;

            // Run the search query
            $stmt->execute();
            $stmt->store_result();

            // Bind result columns
            $stmt->bind_result($question, $questionId);
            
            // If any row matches, store it
            if($stmt->fetch())
            {
                /**
                 * Use questionId as key to prevent duplicates.
                 * This means if two keywords match the same question,
                 * it only appears once in the output.
                 */
                $Arr[$questionId] = $question;
            }
        }

        return $Arr;
    }

    public function printQ(){
        /**
         * Debug helper: prints all matched question IDs and their text.
         * Used only for troubleshooting.
         */
        foreach($this->QArr as $id => $q)
        {
            echo $id . ": " . $q;
        }
    }

    private function getKeywordArr($Q)
    {
        /**
         * Extract keyword IDs by scanning user input word-by-word.
         * 
         * Expected:
         *      $Q is an array with index 'question'.
         * 
         * Steps:
         *  1. Lowercase the user's sentence
         *  2. Split sentence into individual words
         *  3. Check each word against keyWords(keyword)
         *  4. Store keywordId for each matched keyword
         */

        $lowerCaseInput = strtolower($Q['question']);
        $inputArr = explode(" ", $lowerCaseInput);
        $keywordArr = [];

        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        // Prepare lookup query for a single keyword
        $stmt = $conn->prepare('SELECT keyWordId FROM keyWords WHERE keyword = ?');
        $stmt->bind_param('s', $possibleKey);

        // Check every word in the question
        foreach($inputArr as $word)
        {
            // Set the search parameter
            $possibleKey = $word;

            // Run SELECT keyWordId ...
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($keywordId);

            // If a matching keyword is found → store it
            if($stmt->fetch())
            {
                // Store keywordId as both key and value to avoid duplicates
                $keywordArr[$keywordId] = $keywordId;
            }
        }

        // If no matches → return an empty array
        if (!empty($keywordArr)) {
            return $keywordArr;
        } else {
            echo "there is no key word in the question";
            return [];
        }

        // NOTE: This line is unreachable because of the return above
        $conn->close();
    }

    public function getSynonymsFromDatamuse(string $word): array
    {
        /**
         * Fetch synonyms using the external Datamuse API.
         * 
         * Example request:
         *      https://api.datamuse.com/words?rel_syn=fast
         * 
         * Returns:
         *      An array of synonym strings.
         * 
         * Error handling:
         *      - If API is unreachable → return empty array
         *      - If JSON is malformed → return empty array
         */

        $url = 'https://api.datamuse.com/words?rel_syn=' . urlencode($word);

        // Safely try to fetch the data (suppress warnings)
        $json = @file_get_contents($url);

        if ($json === false) {
            // API unreachable, timeout, or offline
            return [];
        }

        // Convert JSON string into PHP associative array
        $data = json_decode($json, true);

        if (!is_array($data)) {
            // If the API responded with non-JSON content
            return [];
        }

        $result = [];

        // Extract the "word" field from each returned object
        foreach ($data as $item) {
            if (isset($item['word'])) {
                $result[] = $item['word'];
            }
        }

        return $result;
    }
    
}

?>
