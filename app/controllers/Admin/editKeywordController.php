<?php
require_once __DIR__ . '/../../config/dbOOP.php'; // DB connection
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';


class editKeywordController{
    public $keyword;   // The ID of the keyword to edit
    public $keywordId; // The new keyword value
    public editkeyword $editKeywordModel;

    public function __construct($post){
        $this->keyword = $post['identificatorValue'];
        $this->keywordId = $post['identificatorId'];
        $this->editKeywordModel = new editkeyword($this->keywordId, $this->keyword);
       
    }
    public function handle(){
                $this->editKeywordModel->editkeyword();
    }
}

?>