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
        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');

        // Query questions where any keyword column matches
        $stmt = $conn->prepare('SELECT * FROM questions WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ? OR keyword4 = ? OR keyword5 = ? OR keyword6 = ? OR keyword7 = ? OR keyword8 = ? OR keyword9 = ? OR keyword10 = ?');
        $Arr = [];
        
        // Check each keyword against the database
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
