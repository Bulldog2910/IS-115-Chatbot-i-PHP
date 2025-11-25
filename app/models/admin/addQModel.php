<?php
class addQModel {
    public $addQLog = [];
    public $QDesc;
    public $ADesc;
    public $keywordArr = [];
    public $keywordIds = [];
    public $keyword1;
    public $keyword2;
    public $keyword3;
    public $keyword4;
    public $keyword5;
    public $keyword6;
    public $keyword7;
    public $keyword8;
    public $keyword9;
    public $keyword10;
    public $category;

    public function __construct($postArr)
    {
        foreach ($this as $prop => $value) {
            if (isset($postArr[$prop])) {
                $this->$prop = strtolower(trim($postArr[$prop] ?? ''));
            }
        }
        $this->keywordArr = [$this->keyword1, $this->keyword2, $this->keyword3, $this->keyword4, $this->keyword5, $this->keyword6, $this->keyword7, $this->keyword8, $this->keyword9, $this->keyword10];
        $this->checkKeywordExist();
        print_r($this->addQLog);
        print_r($this->keywordArr);
    }


    public function checkKeywordExist(){
        require __DIR__ . '/../../config/dbOOP.php';
        $conn->select_db('FAQUiaChatbot');

        $stmt = $conn->prepare('SELECT * FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);

        foreach($this->keywordArr as $key){
            if($key !== ""){
                $bind = $key;
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0){

                    $add = $conn->prepare('INSERT INTO keywords (keyword) VALUES (?)');
                    $add->bind_param('s', $key);
                    $add->execute();

                    $keyId = intval($this->getkeywordId($key));
                    $this->addQLog[] = '"' . $key . '" added to keywords table';

                } else {
                    $this->addQLog[] = '"' . $key . '" allready exists in keywords table';
                    $row = $result->fetch_assoc();
                    $keyId = intval($row['keywordId']);
                    
                }
                $this->keywordIds[] = $keyId;
            }
            else{
                $this->keywordIds[] = null;
            }
            
        }
    }


    private function getkeywordId($bind){
        require __DIR__ . '/../../config/dbOOP.php';
        $conn->select_db('FAQUiaChatbot');
        $stmt = $conn->prepare('SELECT keywordId FROM keywords WHERE keyword = ?');
        $stmt->bind_param('s', $bind);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['keywordId'];
    }
}