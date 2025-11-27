<?php
class quickQ{
    public $value;
    public $info = [];
    public function __construct($post)
    {
        $this->value = $post['quickQuestion'];
        $this->getQInfo();

    }

    private function getQInfo(){
        require __DIR__ . '/../../config/dbOOP.php';
        $conn->select_db('FAQUiaChatbot');
        $stmt = $conn->prepare('SELECT * FROM questions WHERE questionId = ?');
        $stmt->bind_param('i', $this->value);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $this->info[$row['questionId']] = [$row['questionDescription'], $row['questionAnswer']];
    }
}