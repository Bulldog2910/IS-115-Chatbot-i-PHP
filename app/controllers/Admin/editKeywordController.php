<?php
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';

class editKeywordController{
    private mysqli $conn;
    public $keyword;   // The new keyword value
    public $keywordId; // The ID of the keyword to edit
    public editKeyword $editKeywordModel;

    public function __construct($conn, $post){
        
        $this->conn = $conn;
        $this->keyword = $post['identificatorValue'];
        $this->keywordId = $post['identificatorId'];
        $this->editKeywordModel = new editKeyword($this->conn, $this->keywordId, $this->keyword);
       
    }
    public function handle(){
                $this->editKeywordModel->editkeyword();
    }
}

?>