<?php
class scoring {
    public $QArr = [];
    public $keyArr = [];
    public $scoreArr = [];
    public $bestScore = [];
    public function __construct($chatbotModel)
    {
        if($chatbotModel->QArr == "Found no keywords in the question"){
            $this->bestScore['No keyword'] = ['No keywords found', 'Try again with different wording'];
        }else{
            $this->QArr = $chatbotModel->QArr;
            $this->keyArr = $chatbotModel->keywordArr;
            $this->rankQ();
            $this->sortRank();
            $this->bestScore();
        }
        
    }

    private function rankQ(){
        require __DIR__ . '/../../config/dbOOP.php';
        $conn->select_db('FAQUiaChatbot');

        foreach($this->QArr as $QId => $Qinfo){
            $score = 0;
            $stmt = $conn->prepare('SELECT * FROM questions WHERE questionId = ?');
            $stmt->bind_param('i', $QId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            foreach($this->keyArr as $keyId => $value ){

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
                $this->scoreArr[] = [
                    "questionId" => $QId,
                    "score" => $score
                ];
            }
        }
    private function sortRank(){
        usort($this->scoreArr, function($a, $b){
            return $b['score'] - $a['score']; 
        });
    }
    private function bestScore(){
        $bestQId = $this->scoreArr[0]['questionId'];

        $this->bestScore[$bestQId] = $this->QArr[$bestQId];
    }
}
    
?>