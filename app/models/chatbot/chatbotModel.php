<?php 

class chatbotModel{
    public $keywordArr;   // IDs of matched keywords
    public $QArr;         // Questions matched to these keywords
    public $chatbotLog;
    public $wordArr;


    function __construct($lemmaArr)
    {
        $this->keywordArr = $this->getKeywordArr($lemmaArr);   // extract keyword IDs from input
        if($this->keywordArr == []){
            $this->QArr = "Found no keywords in the question";
        } else{
                $this->QArr = $this->getQArr();  // fetch matching questions
        }


                       
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

        include __DIR__ . '/../../config/db.php';
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

private function getKeywordArr($lemmaArr)
{
    /**
     * Extract all matching keyword IDs by analyzing the user's input text.
     *
     * Process:
     *  1. Convert the user’s question to lowercase
     *  2. Split input into individual words
     *  3. For each word:
     *      - Add the word itself as a candidate keyword
     *      - Fetch synonyms from Datamuse API
     *      - Filter synonyms and add them as candidates
     *  4. For each candidate:
     *      - Compare it with the keyWords table in MySQL
     *      - If it matches, store the keywordId
     *
     */

    // Will hold ALL matched keyword IDs
    $keywordArr = [];

    // Connect to database
    include __DIR__ . '/../../config/dbOOP.php';

    /**
     * Prepared statement for matching candidate words against the database.
     *
     * LOWER(keyword) = ?  makes the comparison case-insensitive.
     * Example:
     *   DB value: "book"
     *   Candidate: "book"
     *   → Match
     */
    $stmt = $conn->prepare('SELECT keywordId FROM keyWords WHERE LOWER(keyword) = ?');
    if (!$stmt) {
        // If prepare fails, stop function early
        return [];
    }

    // Loop through every word extracted from the user input
    foreach ($lemmaArr as $word) {

        // Clean whitespace (safety measure)
        $word = trim($word);
        if ($word === '') {
            // Skip empty results from explode
            continue;
        }

        /**
         * STEP 1: Add the original user word as the first candidate.
         * Example:
         *      Input: "hold"
         *      → candidates = ["hold"]
         */
        $candidates = [$word];

        /**
         * STEP 2: Fetch synonyms from Datamuse API
         * Synonyms expand the search so:
         *      Input: "hold"
         *      → synonyms: ["retain", "carry", "book", ...]
         */
        $synonyms = $this->getSynonymsFromDatamuse($word);

        // Filter synonyms:
        // - Remove empty strings
        // - Skip synonyms containing spaces (multi-word phrases)
        foreach ($synonyms as $syn) {
            $syn = trim($syn);
            if ($syn === '' || strpos($syn, ' ') !== false) {
                continue;
            }
            $candidates[] = $syn; // Add valid synonym as candidate
        }

        /**
         * STEP 3: Compare each candidate against the keyWords table
         */
        foreach ($candidates as $candidate) {

            // Normalize candidate for matching (lowercase)
            $possibleKey = strtolower($candidate);

            // Bind candidate word to prepared SQL statement
            $stmt->bind_param('s', $possibleKey);

            // Execute SQL: SELECT keywordId FROM keyWords WHERE LOWER(keyword) = ?
            $stmt->execute();

            // Bind the resulting keywordId output from the query
            $stmt->bind_result($keywordId);

            /**
             * If the statement returns rows:
             * - fetch() loads keywordId into $keywordId
             * - store it in $keywordArr
             */
            while ($stmt->fetch()) {

                // DEBUG: Show which candidate matched which keywordId
                $this->chatbotLog[] = "MATCH: '{$possibleKey}' => keywordId {$keywordId}<br>"; 

                // Store keywordId twice (key and value) to avoid duplicates
                $keywordArr[$keywordId] = $keywordId;
            }
        }
    }

    // Cleanup prepared statement + DB connection
    $stmt->close();
    $conn->close();

    // If one or more keywords matched → return them
    if (!empty($keywordArr)) {
        return $keywordArr;
    }

    // No keywords matched any word or synonym
    $chatbotLog[] = "there is no key word in the question";
    return [];
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
