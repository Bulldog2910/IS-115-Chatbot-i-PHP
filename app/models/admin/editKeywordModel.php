<?php 
class editkeyword{
    public $keyword;
    public $keywordId;

    public function __construct($id, $value)
    {
        $trimmed = trim($value);
        $this->keywordId = strtolower($trimmed);
        $this->keyword = $id;
    }
}