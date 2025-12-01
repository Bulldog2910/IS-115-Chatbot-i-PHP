<?php
require __DIR__ . '/../../models/admin/addQModel.php';

/*Add question controller*/
class addQController{
    private mysqli $conn;
    public $keywordArr = [];     // Array containing all keywords
    // Question fields
    public $questionDescription; // Text description of the question
    public $questionAnswer;      // Text answer of the question
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

    public function __construct($conn, $postArr)
    {
        $this->conn = $conn;

        // Get question fields (NOT lowercased)
        $this->questionDescription = trim($postArr['questionDescription'] ?? '');
        $this->questionAnswer      = trim($postArr['questionAnswer'] ?? '');
        

        // Get keywords (lowercased)
        for ($i = 1; $i <= 10; $i++) {
            $key = 'keyword' . $i;
            $this->$key = strtolower(trim($postArr[$key] ?? ''));
            $this->keywordArr[] = $this->$key;
        }
        $this->keywordArr = [
            $this->keyword1, $this->keyword2, $this->keyword3, $this->keyword4, $this->keyword5,
            $this->keyword6, $this->keyword7, $this->keyword8, $this->keyword9, $this->keyword10
        ];
        $addQ = new addQModel(
            $this->keywordArr, 
            $this->conn, 
            $this->questionDescription, 
            $this->questionAnswer
        );
        
        $addQ->checkKeywordExist();
        $addQ->addQuestion();

        return $addQ->addQLog;
    }

    }
    





