<?php
/*
 * scoring Class
 * 
 * Purpose:
 *  - Assigns a relevance score to all matched questions from the chatbot.
 *  - Higher scores are given for keywords that appear earlier in the question's keyword list.
 *  - Returns the best-matching question for the user's input.
 */
class scoring {
    public $QArr = [];       // Questions matched from chatbotModel: [questionId => [description, answer]]
    public $keyArr = [];     // Keyword IDs extracted from user input
    public $scoreArr = [];   // Array storing computed scores for each question
    public $bestScore = [];  // The highest-scoring question (best match)

    /**
     * Constructor
     * @param object $chatbotModel An instance of chatbotModel containing matched questions & keywords
     */
    public function __construct($chatbotModel)
    {
        // If no keywords were found in the user's input
        if($chatbotModel->QArr == "Found no keywords in the question") {
            $this->bestScore['No keyword'] = [
                'No keywords found',
                'Try again with different wording'
            ];
        } else {
            // Store matched questions and keywords
            $this->QArr = $chatbotModel->QArr;
            $this->keyArr = $chatbotModel->keywordArr;

            // Compute scores for all questions
            $this->rankQ();

            // Sort questions by descending score
            $this->sortRank();

            // Store the highest-scoring question
            $this->bestScore();
        }
    }

    /**
     * Compute a relevance score for each question based on keyword positions
     */
    private function rankQ()
    {
        require __DIR__ . '/../../config/dbOOP.php';
        $conn->select_db('FAQUiaChatbot');

        // Iterate through all questions
        foreach($this->QArr as $QId => $Qinfo) {
            $score = 0;

            // Fetch the full question row from DB (includes keyword1..keyword10)
            $stmt = $conn->prepare('SELECT * FROM questions WHERE questionId = ?');
            $stmt->bind_param('i', $QId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // For each input keyword, check if it matches any keyword column
            foreach($this->keyArr as $keyId => $value) {
                if ($keyId == $row['keyword1'])  $score += 10;
                if ($keyId == $row['keyword2'])  $score += 9;
                if ($keyId == $row['keyword3'])  $score += 8;
                if ($keyId == $row['keyword4'])  $score += 7;
                if ($keyId == $row['keyword5'])  $score += 6;
                if ($keyId == $row['keyword6'])  $score += 5;
                if ($keyId == $row['keyword7'])  $score += 4;
                if ($keyId == $row['keyword8'])  $score += 3;
                if ($keyId == $row['keyword9'])  $score += 2;
                if ($keyId == $row['keyword10']) $score += 1;
            }

            // Store the question ID and its computed score
            $this->scoreArr[] = [
                "questionId" => $QId,
                "score" => $score
            ];
        }
    }

    /**
     * Sort the questions in descending order of score
     */
    private function sortRank()
    {
        usort($this->scoreArr, function($a, $b){
            return $b['score'] - $a['score']; 
        });
    }

    /**
     * Pick the best-scoring question
     * Stores the question info in $bestScore
     */
    private function bestScore()
    {
        $bestQId = $this->scoreArr[0]['questionId'];
        $this->bestScore[$bestQId] = $this->QArr[$bestQId];
    }
}
?>
