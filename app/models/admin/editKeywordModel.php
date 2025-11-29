<?php 
class editkeyword{
    public $keyword;
    public $keywordId;
    public $err = [];
    public $log = [];

    public function __construct($id, $value)
    {
        $trimmed = trim($value);
        $this->keywordId = strtolower($trimmed);
        $this->keyword = $id;
    }

    function editKeyword(){
        require __DIR__ . '/../../config/dbOOP.php';

        $id = $this->keyword;
        $keyword = $this->keywordId;

        $stmt = $conn->prepare('SELECT * FROM keyWords WHERE keyword = ?');
        $stmt->bind_param('s', $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($result->num_rows !== 0 ){
            $err['DB-01'] = 'Keyword allready exist with Keyid: ' . $row['keywordId'] ;
        }else{
            $stmt = $conn->prepare('UPDATE keyWords SET keyword = ? WHERE keywordId = ?');
            $stmt->bind_param('si', $keyword, $id);
            if($stmt->execute()){
                $this->log[] = 'DB: updated correctly';
            } else{
                $this->err['DB-02'] = 'Error during update of keyword: ' . $stmt->error;
            }
        }
    
    }
    function error(){
        if(!empty($this->err)){
            return $this->err;
        }
        return "No errors";
    }
}
