<?php
class select{
    public $resultQ;
    public $resultChat;
    public $resultKey;

public function __construct()
{
    include __DIR__ . '/../../config/dbOOP.php';

    $conn->select_db('FAQUiaChatbot');
    $stmt = $conn->prepare(
            'SELECT 
            q.questionId,
            q.questionDescription,
            q.questionAnswer,
            k1.keyword AS keyword1,
            k2.keyword AS keyword2,
            k3.keyword AS keyword3,
            k4.keyword AS keyword4,
            k5.keyword AS keyword5,
            k6.keyword AS keyword6,
            k7.keyword AS keyword7,
            k8.keyword AS keyword8,
            k9.keyword AS keyword9,
            k10.keyword AS keyword10,
            q.category
        FROM questions q
        LEFT JOIN keywords k1 ON q.keyword1 = k1.keywordId
        LEFT JOIN keywords k2 ON q.keyword2 = k2.keywordId
        LEFT JOIN keywords k3 ON q.keyword3 = k3.keywordId
        LEFT JOIN keywords k4 ON q.keyword4 = k4.keywordId
        LEFT JOIN keywords k5 ON q.keyword5 = k5.keywordId
        LEFT JOIN keywords k6 ON q.keyword6 = k6.keywordId
        LEFT JOIN keywords k7 ON q.keyword7 = k7.keywordId
        LEFT JOIN keywords k8 ON q.keyword8 = k8.keywordId
        LEFT JOIN keywords k9 ON q.keyword9 = k9.keywordId
        LEFT JOIN keywords k10 ON q.keyword10 = k10.keywordId;'
        );
    $stmt->execute();
    $this->resultQ = $stmt->get_result();

    $stmt = $conn->prepare('SELECT * FROM chatUser');
    $stmt->execute();
    $this->resultChat = $stmt->get_result();

    $stmt = $conn->prepare('SELECT * FROM keyWords');
    $stmt->execute();
    $this->resultKey = $stmt->get_result();
}

}
?>