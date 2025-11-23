<?php 

class chatbotModel{
    private $keywordArr;   // IDs of matched keywords
    private $QArr;         // Questions matched to these keywords


    function __construct($Q)
    {
        $this->keywordArr = $this->getKeywordArr($Q);   // extract keyword IDs from input
        $this->QArr = $this->getQArr();                 // fetch matching questions
    }

    public function getQArr()
    {
        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        // Query questions where any keyword column matches
        $stmt = $conn->prepare('SELECT questionDescription, questionId FROM questions WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ?');
        $stmt->bind_param('iii', $possiblekey, $possibleKey, $possibleKey);

        $Arr = [];
        
        // Check each keyword against the database
        foreach($this->keywordArr as $key)
        {
            $possibleKey = $key;
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($question, $questionId );
            
            if($stmt->fetch())     // store match
            {
                $Arr[$questionId] = $question;
            }

        }
        return $Arr;
    }

    public function printQ(){
        // Simple output for debugging
        foreach($this->QArr as $id => $q)
            {
                echo $id . ": " . $q;
            }
    }

    private function getKeywordArr($Q)

    {
        $lowerCaseInput = strtolower($Q['question']); // normalize input
        $inputArr = explode(" ", $lowerCaseInput);    // split into words
        $keywordArr = [];

        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        // Check whether each word exists as a keyword
        $stmt = $conn->prepare('SELECT keyWordId FROM keyWords WHERE keyword = ?');
        $stmt->bind_param('s', $possibleKey);

        foreach($inputArr as $word)
        {
            $possibleKey = $word;
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($keywordId);

            if($stmt->fetch())     // store valid keyword ID
            {
                $keywordArr[$keywordId] = $keywordId;
            }
        }

        if(!empty($keywordArr))
        {
            return $keywordArr;
        }else
        {
            echo "there is no key word in the question"; // no keyword found
            return false;
        }

        $conn->close(); // unreachable but left as-is
    }

    
}

?>
