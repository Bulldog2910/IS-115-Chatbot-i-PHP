<?php 

class chatbotModel{
    public $keywordArr;   // IDs of matched keywords
    public $QArr;         // Questions matched to these keywords


    function __construct($Q)
    {
        $this->keywordArr = $this->getKeywordArr($Q);   // extract keyword IDs from input
        if($this->keywordArr === false){
            $this->QArr = "Found no keywords in the question";
        } else{
                $this->QArr = $this->getQArr();  // fetch matching questions
        }
        print_r($this->keywordArr);
        print_r($this->QArr);
                       
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

        // Query questions where any keyword column matches
        $stmt = $conn->prepare('SELECT * FROM questions WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ? OR keyword4 = ? OR keyword5 = ? OR keyword6 = ? OR keyword7 = ? OR keyword8 = ? OR keyword9 = ? OR keyword10 = ?');
        $Arr = [];
        
        // Loop through all discovered keyword IDs
        foreach($this->keywordArr as $key)
        {
            $stmt->bind_param('iiiiiiiiii', $key, $key, $key, $key, $key, $key, $key, $key, $key, $key);

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $Arr[$row['questionId']] = [
                    $row['questionDescription'],
                    $row['questionAnswer']
                ];
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
