<?php 

class chatbotModel{
    private $keywordArr;
    private $QArr;


    function __construct($Q)
    {
        $this->keywordArr = $this->getKeywordArr($Q);
        $this->QArr = $this->getQArr();
    }

    public function getQArr()
    {
        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');
        $stmt = $conn->prepare('SELECT questionDescription, questionId FROM questions WHERE keyword1 = ? OR keyword2 = ? OR keyword3 = ?');
        $stmt->bind_param('iii', $possiblekey, $possibleKey, $possibleKey);
        $Arr = [];
        
        foreach($this->keywordArr as $key)
        {
            $possibleKey = $key;
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($question, $questionId );
            
            if($stmt->fetch())
            {
                $Arr[$questionId] = $question;
            }

        }
        return $Arr;
    }

    public function printQ(){
        foreach($this->QArr as $id => $q)
            {
                echo $id . ": " . $q;
            }
    }

    private function getKeywordArr($Q)

    {
        $lowerCaseInput = strtolower($Q['question']);
        $inputArr = explode(" ", $lowerCaseInput);
        $keywordArr = [];
        include __DIR__ . '/../config/db.php';
        mysqli_select_db($conn, 'FAQUiaChatbot');
        $stmt = $conn->prepare('SELECT keyWordId FROM keyWords WHERE keyword = ?');
        $stmt->bind_param('s', $possibleKey);

        foreach($inputArr as $word)
        {
            $possibleKey = $word;
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($keywordId);

            if($stmt->fetch())
            {
                $keywordArr[$keywordId] = $keywordId;
            }
        }
        if(!empty($keywordArr))
        {
            return $keywordArr;
        }else
        {
            echo "there is no key word in the question";
            return false;
        }
        $conn->close();
    }

    
}

?>