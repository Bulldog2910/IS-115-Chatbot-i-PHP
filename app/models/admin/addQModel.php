<?php
class addQModel {
    public $QDesc;
    public $ADesc;
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
    }
}